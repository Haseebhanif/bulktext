<?php

namespace App\Http\Livewire\Payments;

use App\Http\Traits\EmailConfigSettingTrait;
use App\Http\Traits\UsesTeamCredits;
use App\Mail\CreditsApplied;
use App\Models\Company;
use App\Models\PaymentRecord;
use App\Models\StripePerTenant;
use App\Models\Tenant;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Stripe\Stripe;

class StripeGateway extends Component
{
    use LivewireAlert;
    use UsesTeamCredits;
    use EmailConfigSettingTrait;

    protected $listeners =[
        'refreshCard'=>'$refresh',
        'paymentMethodUpdated'=>'LinkCardToCustomer',
        'ccConfirmed'=>'confirm',
        'defaultCard'=>'setDefault',
        'Cancel'=>'cancelled',
        'errorMessage'=>'ErrorOnCard'];


    public $user;
    public $defaultCard;
    public $newIntent = false;
    public $creditRate;
    public $selectedCard;

    public $creditsWanted = 1000;
    public $creditsPrice;
    public $paymentMethod;

    public $creditChange = false;
    public $confirmPurchase =false;

    public $stripeTenant;

    public $stripeKey;

    public $vat;
    public $vatRate = 20;
    public $totalPriceToPay = 0.00;

    public function mount()
    {

        $tenant  = Tenant::where('domain',Session::get('domain'))->first();
        $this->stripeTenant =  StripePerTenant::where('tenant_id', $tenant->id)->first();
        $this->vatRate  = \config('app.vat_rate');



    if($this->stripeTenant){

        $this->stripeKey =  $this->stripeTenant->stripe_token_live;
        Config::set('cashier.key', $this->stripeTenant->stripe_token_live);
        Config::set('cashier.secret', $this->stripeTenant->stripe_secret_live);



    }else{

        $this->stripeKey = env('STRIPE_KEY');
        Config::set('cashier.key', env('STRIPE_KEY'));
        Config::set('cashier.secret', env('STRIPE_SECRET'));
    }



        $this->user = Auth::user();





        $this->paymentMethod = $this->user->defaultPaymentMethod() ? $this->user->defaultPaymentMethod()->id : null;
        $this->creditRate = $this->user->currentTeam->company->credit_rate;
        $this->costCalculation();
    }


    public function render()
    {



        $this->newIntent = false;
        $this->costCalculation();

        $this->creditsPrice=  preg_replace('/[^\d.]/', '', $this->creditsPrice);
        $this->vat = preg_replace('/[^\d.]/', '', $this->vat);


        return view('livewire.payments.stripe-gateway',[
            'intent' =>  $this->user->createSetupIntent(),
            'paymentMethods' => $this->user->paymentMethods()
        ]);
    }


    public function vatCalculation(){

        // Remove commas and other non-numeric characters except the decimal point
        $formattedCreditsPrice = preg_replace('/[^\d.]/', '', $this->creditsPrice);
        $this->vat = round( ($formattedCreditsPrice / 100) * $this->vatRate, 2);
    }


    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        if(!$this->paymentMethod){
            $this->alert('warning', 'Please add payment method!');
            return;
        }


        Stripe\Charge::create ([
            "amount" => 100 * 100,
            "currency" => "GBP",
            "source" => $request->stripeToken,
            "description" => "Test payment from LaravelTus.com."
        ]);

        $this->alert('success', 'Payment successful!');
        $this->newIntent = true;
    }


    /**
     * Adds payment details to user
     * @param $data
     */
    public function LinkCardToCustomer($data){



        $stripeCustomer = $this->user->createOrGetStripeCustomer();

        if(!$stripeCustomer){
            $this->alert('warning', 'Issue with Adding Payment Method!');
        }else{
            $user = Auth::user();
            if ($user->hasPaymentMethod()) {

                $paymentMethods = $user->paymentMethods();
                $paymentMethod =  $paymentMethods[0];
                $user->updateDefaultPaymentMethod($paymentMethod->id);

            }
            $this->user->addPaymentMethod($data);
            $this->user->updateDefaultPaymentMethod($data);
            $this->alert('success', 'Payment Method Added!');


        }
        $this->newIntent = true;
        $this->user = $user;
        $this->emit('reloadScript');
        $this->emit('refreshCard');
        return redirect('/credits');

    }


    public function setDefault(){
       $user = Auth::user();

        if ($user->hasPaymentMethod() && !$user->hasDefaultPaymentMethod()) {

            $paymentMethods = $user->paymentMethods();
            $paymentMethod =  $paymentMethods[0];
            $user->updateDefaultPaymentMethod($paymentMethod->id);
            $this->paymentMethod = $user->defaultPaymentMethod()->id;
            return redirect('/credits');
        }

    }


    public function setDefaultCard($pm){
        $this->user->updateDefaultPaymentMethod($pm);
        $this->paymentMethod = $this->user->defaultPaymentMethod()->id;
        $this->emit('reloadScript');
    }

    public function remove($pm)
    {

        $this->selectedCard = $pm;
        $this->alert('question', 'Removing Payment method, Are you sure?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'onConfirmed' => 'ccConfirmed',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'onCancel' => 'Cancel',
            'timer' => null
        ]);
        $this->emitSelf('reloadScript');
    }

    public function confirm(){
        $this->newIntent = true;
        $paymentMethod = $this->user->findPaymentMethod($this->selectedCard);
        $paymentMethod->delete();


      $methods =   $this->user->paymentMethods();


      if(count($methods) >= 1){
                $this->user->updateDefaultPaymentMethod($methods[0]->id);
      }

        $this->alert('success', 'Payment Method Removed!');
        $this->emit('refreshCard');
        $this->emit('reloadScript');


    }


    public function cancelled()
    {
        $this->emitSelf('reloadScript');
    }


    public function costCalculation(){

      // dd($this->creditsWanted);
        if($this->creditsWanted != null && $this->creditsWanted >= 500 ){
            $this->creditsPrice = number_format(($this->creditsWanted*$this->creditRate),'2','.',',');
        }else{
            $this->creditsWanted = 500;
            $this->creditsPrice = number_format((500*$this->creditRate),'2','.',',');

        }
        $this->vatCalculation();
        $this->emit('reloadScript');
    }



    public function processPayment(){

        $this->confirmPurchase =false;
        if ($this->user->hasDefaultPaymentMethod()) {

          $this->costCalculation();
          $creditsPrice=  preg_replace('/[^\d.]/', '', $this->creditsPrice);
          $vat = preg_replace('/[^\d.]/', '', $this->vat);

          $pay = number_format($creditsPrice+$vat,2);

          $amount = (int)str_replace(',', "", str_replace('.', "", $pay));

          $preventDoublePayment =  PaymentRecord::whereBetween('created_at', [Carbon::now()->subSecond(20),Carbon::now()])->count();

          if($preventDoublePayment == 0){
              try {

                  $payment = $this->user->charge($amount, $this->paymentMethod);
                  $this->response($payment);

              } catch (\Stripe\Exception\CardException $e ) {


                  $errorBody = json_decode($e->getHttpBody());

                  $errorBody->error->status = $errorBody->error->code;

                  $this->response($errorBody->error);
                  $this->emit('reloadScript');


              }
          }else{
              $this->alert('warning', 'We are already processing this order.Only one payment every 20 seconds!');
              $this->emit('reloadScript');
          }


        }else{
            $this->alert('warning', 'Payment Method Required!');
            $this->emit('reloadScript');
        }
    }


    public function getAmount($money)
    {
        $cleanString = preg_replace('/([^0-9\.,])/i', '', $money);
        $onlyNumbersString = preg_replace('/([^0-9])/i', '', $money);

        $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;

        $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
        $removedThousandSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '',  $stringWithCommaOrDot);

        return (float) str_replace(',', '.', $removedThousandSeparator);
    }

    public function response($paymentObj)
    {
        switch ($paymentObj->status) {
            case 'succeeded':
            $paymentRec =    PaymentRecord::create([
                    'payment_ref' => $paymentObj->id,
                    'credits' => $this->creditsWanted,
                    'amount' => $paymentObj->amount,
                    'vat'=>$this->vat,
                    'vat_rate'=>$this->vatRate,
                    'currency' => $paymentObj->currency,
                    'customer_id' => $paymentObj->customer,
                    'status' => $paymentObj->status,
                    'receipt_url' => $paymentObj->receipt_url,
                    'company_id' => $this->user->currentTeam->company->id,
                    'team_id' => $this->user->currentTeam->id,
                    'created_by' => $this->user->id,
                ]);

                $this->addCredits($this->creditsWanted);
                $this->emit('creditUpdate');
                $this->alert('success', 'Payment Successful Credits added!');



            if($paymentRec){


                $file = 'invoice_'.$paymentRec->payment_ref.'.pdf';

                 $paymentRecord =PaymentRecord::with('company')->findOrFail($paymentRec->id);
                 $pdf = PDF::loadView('payments.template.invoice1', compact('paymentRecord'));
                 $pdf->save($file,'temp');

               $branding =  $this->emailBranding();

                Mail::to(Auth::user()->email)
                    ->cc(Auth::user()->currentTeam->owner->email)
                    ->bcc($this->user->currentTeam->company->companyCreator->email)
                    ->bcc('andrew.yeomans@outlook.com')
                    ->send(new CreditsApplied($paymentRec,$branding,$file));

                Mail::to(Auth::user()->email)
                    ->cc(Auth::user()->currentTeam->owner->email)
                    ->bcc($this->user->currentTeam->company->companyCreator->email)
                    ->bcc('andrew.yeomans@outlook.com')
                    ->queue(new CreditsApplied($paymentRec,$branding,$file));

                File::delete('/var/temp/'.$file);
            }



                $this->emit('reloadScript');
                return ;
            case 'pending':
                $this->emit('reloadScript');

                return;

            case 'failed':
            case 'card_declined':
                 $this->alert('warning', $paymentObj->message);
            $this->emit('refreshCard');
            return  ;

            default :
                $this->alert('warning', $paymentObj->message);
                $this->emit('reloadScript');


        }
    }



    public function ErrorOnCard($data){
        $this->alert('warning', $data['message']);
        $this->emit('reloadScript');
    }





}
