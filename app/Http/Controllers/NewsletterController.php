<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Enums\NewsletterStatus;
use App\Http\Requests\StoreNewsletterRequest;
use App\Http\Resources\NewsletterCollection;
use App\Http\Resources\NewsletterRecipientStats;
use App\Http\Resources\NewsletterResource;
use App\Jobs\SendNewsletter;
use App\Mail\NewsletterEmail;
use App\Newsletter;
use App\NewsletterRecipient;
use App\Repositories\NewsletterRepository;
use App\User;
use DemeterChain\Main;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    private $repo;
    public function __construct(NewsletterRepository $repository)
    {
        $this->repo = $repository;
    }
    public function index()
    {
        return new NewsletterCollection($this->repo->index());
    }
    public function show($uuid)
    {
        return new NewsletterResource($this->repo->show($uuid));
    }
    public function store(StoreNewsletterRequest $request)
    {
        $authUser = auth()->user();
        $data = $request->all();
        $data['company_id'] = $authUser->company_id;

        return new NewsletterResource($this->repo->updateOrCreate($data));
    }
    public function destroy($uuid)
    {
        $this->repo->destroy($uuid);
        return response()->json(['message' => __('api.NEWSLETTER_DELETED')]);
    }

    public function sendTestEmail(Request $request, $uuid)
    {
        $newsletter = Newsletter::findByUUIDOrFail($uuid);

        $request->validate(['email' => 'required|email']);
        Mail::to($request->email)->queue(new NewsletterEmail($newsletter));

        return json_response(__('api.EMAIL_SENT'));
    }
    public function sendNewsLetterEmails($uuid)
    {
        $newsletter = Newsletter::findByUUIDOrFail($uuid);

        $customerGroupIds = $newsletter->company_group_ids;
        $recipients = Customer::where('company_id', $newsletter->company_id)
            ->whereHas('company_groups', function ($q)use($customerGroupIds){
                $q->whereIn('uuid', $customerGroupIds);
            })
            ->get();
        foreach ($recipients as $recipient) {
            $newsletterRecipient = NewsletterRecipient::create([
                'newsletter_id' => $newsletter->id,
                'recipient_id' => $recipient->id
            ]);
            $newsletterRecipient->setRelations([
                'recipient' => $recipient,
                'newsletter' => $newsletter]);

            SendNewsletter::dispatch($newsletterRecipient);
        }

        $newsletter->update(['status' => NewsletterStatus::SENT]);
        return json_response(__('api.SENDING_EMAILS'));
    }

    public function stats($uuid)
    {
        $newsletter = Newsletter::with('recipients')->where('uuid', $uuid)->firstOrFail();
        return new NewsletterRecipientStats($newsletter);

    }
}
