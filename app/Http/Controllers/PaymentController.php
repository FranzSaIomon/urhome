<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;

/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;
use App\Subscription;
use App\BrokerInformation;

class PaymentController extends Controller
{
    private $_api_context;

    
    public function index() {
        return view('users.subscription')->with(['title' => 'Subscription', 'nolanding' => 'nolanding']);
    }

    public function __construct()
    {
        $paypal_conf = config('paypal');
        
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            config('paypal.client_id'),
            config('paypal.secret'))
        );

        $this->_api_context->setConfig(config('paypal.settings'));
    }

    public function payWithpaypal(Request $request, Subscription $subscription)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName($subscription->Name . " Package @ UrHome") /** item name **/
                    ->setCurrency('PHP')
                    ->setQuantity(1)
                    ->setPrice($subscription->Price); /** unit price **/
        $item_list = new ItemList();
                $item_list->setItems(array($item_1));
        $amount = new Amount();
                $amount->setCurrency('PHP')
                    ->setTotal($subscription->Price);
        $transaction = new Transaction();
                $transaction->setAmount($amount)
                    ->setItemList($item_list)
                    ->setDescription('Your transaction description');
        $redirect_urls = new RedirectUrls();
                $redirect_urls->setReturnUrl(URL::route('status')) /** Specify return URL **/
                    ->setCancelUrl(URL::route('subscription'));
        $payment = new Payment();
                $payment->setIntent('Sale')
                    ->setPayer($payer)
                    ->setRedirectUrls($redirect_urls)
                    ->setTransactions(array($transaction));
                /** dd($payment->create($this->_api_context));exit; **/

        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            dd($ex);
            if (\Config::get('app.debug')) {
            \Session::put('error', 'Connection timeout');
                            return Redirect::route('subscription');
            } else {
            \Session::put('error', 'Some error occur, sorry for inconvenient');
                            return Redirect::route('subscription');
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        Session::put("subscription", $subscription->id);

        if (isset($redirect_url)) {
        /** redirect to paypal **/
                    return Redirect::away($redirect_url);
        }
        \Session::put('error', 'Unknown error occurred');
                return Redirect::route('subscription');
    }

    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
                Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {

            \Session::put('error', 'Payment failed');
                        return Redirect::route('profile');
        }

        $payment = Payment::get($payment_id, $this->_api_context);
                $execution = new PaymentExecution();
                $execution->setPayerId(Input::get('PayerID'));
        /**Execute the payment **/
                $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {


            if (auth()->check() && auth()->user()->UserType == 2) {
                $broker = BrokerInformation::where("UserID", auth()->id())->update([
                    "SubscriptionID" => intval(Session::get('subscription', 1)),
                    "SubscriptionStart" => date('Y-m-d G:i:s'),
                ]);
            }

            \Session::put('success', 'Payment success');
                        return Redirect::route('profile');
            
        }
        
        \Session::put('error', 'Payment failed');
                return Redirect::route('/');
    }
}
