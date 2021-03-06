<?php

namespace App\Http\Controllers\Frontend;

use Route;
use Illuminate\Support\Facades\Input;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Hash;
use Session;
use App\Models\Payment;
use App\Models\GardenWaste;
use App\Models\GunnyOrder;
use App\Models\Address;
use Mail;

class PayController extends Controller {

    public function index($id) {
        $user = User::find(Auth::id());
        $amt = Payment::find($id)->invoice_amount;
        return view(Config('constants.frontendView') . '.paynow', compact("user", 'amt', 'id'));
    }

    public function paytm() {
        if (Input::get('payment_for') == 'garden_waste') {
            $id = base64_decode(Input::get('id'));
            $amt = GardenWaste::find($id)->amount;
            $id_prefix = '101';
        } else if (Input::get('payment_for') == 'gunny_bags') {
            $id = base64_decode(Input::get('id'));
            $amt = GunnyOrder::find($id)->amount;
            $id_prefix = '201';
        } else {
            $id = Input::get('id');
            $amt = Payment::find($id)->invoice_amount;
            $id_prefix = '301';
        }
        $mid = 'MobiTr05774251764030';
        $key = '!wfbpZ65Cef%lc%l';
        $type = 'DEFAULT';
        $website = 'Mobitrash';
        $industryTypeId = 'Retail110';
        $channel = 'WEB';
        $cust = Auth::id();
        $mob = Auth::user()->phone_number;
        $email = Auth::user()->email;
        $paramList["MID"] = $mid;
        $paramList["ORDER_ID"] = date("Ymdhis" . "-" . $id_prefix . "-" . $id);
        $paramList["CUST_ID"] = $cust;
        $paramList["INDUSTRY_TYPE_ID"] = $industryTypeId;
        $paramList["CHANNEL_ID"] = $channel;
        $paramList["TXN_AMOUNT"] = $amt;
        $paramList["WEBSITE"] = $website;
        $paramList["MSISDN"] = $mob; //Mobile number of customer
        $paramList["EMAIL"] = $email; //Email ID of customer
        $checksum = $this->getChecksumFromArray($paramList, $key);



        echo "    
            <form action='https://secure.paytm.in/oltp-web/processTransaction' name='f1' method='post'>
                
";
        foreach ($paramList as $name => $value) {
            echo '<input type="hidden" name="' . $name . '" value="' . $value . '">';
        }

        echo "
                <input type='hidden' name='CHECKSUMHASH' value='$checksum' />
            </form>

            <script type='text/javascript'>
		document.f1.submit();
	    </script>
            ";
    }

    public function success() {
        $id = explode("-", Input::get('ORDERID'));
        $invoice_amount = 0;
        $success = 0;
        $redirect = 'user.payment.success';
        $user = User::find(Auth::id())->toArray();
        if ($id[1] == '301') {
            $redirect = 'user.payment.success';
            $pay = Payment::find($id[2]);
            $invoice_amount = $pay->invoice_amount;
            $pay->txtdetails = json_encode(Input::all());
            if (Input::get('STATUS') == "TXN_SUCCESS" || Input::get('RESPCODE') == "01") {
                $pay->payment_made = 1;
                $pay->payment_date = date("Y-m-d");
                $success = 1;
                
                Mail::send(Config('constants.adminEmail') . '.paymentSuccess', ['user' => $user, 'amt' => $invoice_amount], function ($message) {
                    $message->to(Auth::user()->email);
                    $message->cc('getit@mobitrash.in');
                    $message->subject('MobiTrash Payment Receipt');
                });
            } else if (Input::get('STATUS') == "PENDING") {
                $pay->payment_made = 2;
                $pay->payment_date = date("Y-m-d");
                $success = 2;
            } else {
                $success = 0;
            }
            $pay->update();
        } else if ($id[1] == '101') {
            $redirect = 'pickup.order.success';
            $pay = GardenWaste::find($id[2]);
            $address = Address::where('id',$pay->address_id)->first()->toArray();
            $invoice_amount = $pay->amount;
            $pay->txtdetails = json_encode(Input::all());
            if (Input::get('STATUS') == "TXN_SUCCESS" || Input::get('RESPCODE') == "01") {
                $pay->payment_made = 1;
                $pay->payment_date = date("Y-m-d");
                $success = 1;
                Mail::send(Config('constants.frontendEmail') . '.gunnyOrderConfirmation', ['user' => $user, 'no_of_bags'=>$pay->gunny_bags, 'amount'=>$invoice_amount, 'address' => $address], function ($message) use ($user) {
                    $message->to($user['email']);
                    $message->subject('Garden Waste Pickup Order Confirmation');
                });
                Mail::send(Config('constants.frontendEmail') . '.gunnyOrderReceived', ['user' => $user, 'no_of_bags'=>$pay->gunny_bags, 'amount'=>$invoice_amount, 'address' => $address], function ($message) {
                    $message->to('getit@mobitrash.in');
                    $message->subject('Garden Waste Pickup Request Received');
                });
            } else if (Input::get('STATUS') == "PENDING") {
                $pay->payment_made = 2;
                $pay->payment_date = date("Y-m-d");
                $success = 2;
            } else {
                $success = 0;
            }
            $pay->update();
        } else if ($id[1] == '201') {
            $redirect = 'gunny.order.success';
            $pay = GunnyOrder::find($id[2]);
            $invoice_amount = $pay->amount;
            $pay->txtdetails = json_encode(Input::all());
            if (Input::get('STATUS') == "TXN_SUCCESS" || Input::get('RESPCODE') == "01") {
                $pay->payment_made = 1;
                $pay->payment_date = date("Y-m-d");
                $success = 1;
                ////////No pay Email at Save
//                Mail::send(Config('constants.frontendEmail') . '.gunnyOrderConfirmation', ['user' => $user, 'no_of_bags'=>$pay->no_of_bags, 'amount'=>$invoice_amount, 'address' => $address->toArray()], function ($message) use ($user) {
//                    $message->to($user['email']);
//                    $message->subject('Gunny Order Confirmation');
//                });
//                Mail::send(Config('constants.frontendEmail') . '.gunnyOrderReceived', ['user' => $user, 'no_of_bags'=>$pay->no_of_bags, 'amount'=>$invoice_amount, 'address' => $address->toArray()], function ($message) {
//                    $message->to('getit@mobitrash.in');
//                    $message->subject('Pickup Request');
//                });
            } else if (Input::get('STATUS') == "PENDING") {
                $pay->payment_made = 2;
                $pay->payment_date = date("Y-m-d");
                $success = 2;
            } else {
                $success = 0;
            }
            $pay->update();
        }


        if ($success == 1) {
            
        }
        return redirect()->route($redirect, ['success' => $success]);
    }

    public function paymentSuccess() {
        $success = Input::get('success');
        return view(Config('constants.frontendView') . '.thankyou', compact("success"));
    }

    public function pickupOrderSuccess() {
        $success = Input::get('success');
        return view(Config('constants.frontendView') . '.pickupOrderSuccess', compact("success"));
    }

    public function gunnyOederSuccess() {
        $success = Input::get('success');
        if (Input::get('id')) {
            $gunnyOrder = GunnyOrder::with('address')->find(Input::get('id'))->toArray();
        }
        return view(Config('constants.frontendView') . '.gunnyOrderSuccess', compact("success", 'gunnyOrder'));
    }

    public function encrypt_e($input, $ky) {
        $key = $ky;
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
        $input = $this->pkcs5_pad_e($input, $size);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
        $iv = "@@@@&&&&####$$$$";
        mcrypt_generic_init($td, $key, $iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);
        return $data;
    }

    public function decrypt_e($crypt, $ky) {
        $crypt = base64_decode($crypt);
        $key = $ky;
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
        $iv = "@@@@&&&&####$$$$";
        mcrypt_generic_init($td, $key, $iv);
        $decrypted_data = mdecrypt_generic($td, $crypt);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $decrypted_data = pkcs5_unpad_e($decrypted_data);
        $decrypted_data = rtrim($decrypted_data);
        return $decrypted_data;
    }

    public function pkcs5_pad_e($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    public function pkcs5_unpad_e($text) {
        $pad = ord($text{strlen($text) - 1});
        if ($pad > strlen($text))
            return false;
        return substr($text, 0, -1 * $pad);
    }

    public function generateSalt_e($length) {
        $random = "";
        srand((double) microtime() * 1000000);
        $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
        $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
        $data .= "0FGH45OP89";
        for ($i = 0; $i < $length; $i++) {
            $random .= substr($data, (rand() % (strlen($data))), 1);
        }
        return $random;
    }

    public function checkString_e($value) {
        $myvalue = ltrim($value);
        $myvalue = rtrim($myvalue);
        if ($myvalue == 'null')
            $myvalue = '';
        return $myvalue;
    }

    public function getChecksumFromArray($arrayList, $key, $sort = 1) {
        if ($sort != 0) {
            ksort($arrayList);
        }
        $str = $this->getArray2Str($arrayList);
        $salt = $this->generateSalt_e(4);
        $finalString = $str . "|" . $salt;
        $hash = hash("sha256", $finalString);
        $hashString = $hash . $salt;
        $checksum = $this->encrypt_e($hashString, $key);
        return $checksum;
    }

    public function verifychecksum_e($arrayList, $key, $checksumvalue) {
        $arrayList = removeCheckSumParam($arrayList);
        ksort($arrayList);
        $str = getArray2Str($arrayList);
        $paytm_hash = decrypt_e($checksumvalue, $key);
        $salt = substr($paytm_hash, -4);
        $finalString = $str . "|" . $salt;
        $website_hash = hash("sha256", $finalString);
        $website_hash .= $salt;
        $validFlag = "FALSE";
        if ($website_hash == $paytm_hash) {
            $validFlag = "TRUE";
        } else {
            $validFlag = "FALSE";
        }
        return $validFlag;
    }

    public function getArray2Str($arrayList) {
        $paramStr = "";
        $flag = 1;
        foreach ($arrayList as $key => $value) {
            if ($flag) {
                $paramStr .= $this->checkString_e($value);
                $flag = 0;
            } else {
                $paramStr .= "|" . $this->checkString_e($value);
            }
        }
        return $paramStr;
    }

    public function redirect2PG($paramList, $key) {
        $hashString = getchecksumFromArray($paramList);
        $checksum = encrypt_e($hashString, $key);
    }

    public function removeCheckSumParam($arrayList) {
        if (isset($arrayList["CHECKSUMHASH"])) {
            unset($arrayList["CHECKSUMHASH"]);
        }
        return $arrayList;
    }

    public function getTxnStatus($requestParamList) {
        return callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
    }

    public function initiateTxnRefund($requestParamList) {
        $CHECKSUM = getChecksumFromArray($requestParamList, PAYTM_MERCHANT_KEY, 0);
        $requestParamList["CHECKSUM"] = $CHECKSUM;
        return callAPI(PAYTM_REFUND_URL, $requestParamList);
    }

    public function callAPI($apiURL, $requestParamList) {
        $jsonResponse = "";
        $responseParamList = array();
        $JsonData = json_encode($requestParamList);
        $postData = 'JsonData=' . urlencode($JsonData);
        $ch = curl_init($apiURL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($postData))
        );
        $jsonResponse = curl_exec($ch);
        $responseParamList = json_decode($jsonResponse, true);
        return $responseParamList;
    }

}
