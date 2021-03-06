<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Input;
use App\Models\Subscription;
use App\Models\Role;
use App\Models\City;
use App\Models\Wastetype;
use App\Models\Frequency;
use App\Models\Timeslot;
use App\Models\Package;
use App\Models\Pickup;
use App\Models\Attachment;
use App\Http\Controllers\Controller;
use App\Models\Occupancy;
use Request;
use Session;

class SubscriptionController extends Controller {

    function index() {
        $f = Frequency::where("is_active", 1)->get()->toArray();
        $frequency = [];
        foreach ($f as $value) {
            $frequency[$value['id']] = $value['name'];
        }
        $cities = City::where("is_active", 1)->get()->toArray();
        $city = ['' => 'Select City'];
        foreach ($cities as $value) {
            $city[$value['id']] = $value['name'];
        }
        $t = Timeslot::where("is_active", 1)->where("type", 2)->get()->toArray();
        $timeslot = [];
        foreach ($t as $value) {
            $timeslot[$value['id']] = $value['name'];
        }
        
        $filter = array('' => 'All', 'renewal' => 'Due for Renewal', 'frequency_id' => 'Frequency', 'amt_paid' => 'Amount Paid', 'start_date' => 'Start Date', 'end_date' => 'End Date', 'name' => 'Subscription Name', 'city_id' => 'City');

        $filter_type = NULL;
        $filter_value = NULL;
        $field1 = NULL;
        $field2 = NULL;
        $field3 = NULL;
        $field4 = NULL;
        $field5 = NULL;
        $field6 = NULL;
        $field7 = NULL;
        if (Input::get('filter_value') && Input::get('filter_type')) {
            $filter_type = Input::get('filter_type');
            $filter_value = Input::get('filter_value');
            if ($filter_type == 'name') {
                $field6 = Input::get('filter_value');
                $subscription = Subscription::where('name', 'LIKE', "%" . Input::get('filter_value') . "%")->orderBy('created_at', 'desc')->paginate(Config('constants.paginateNo'));
            } else {
                if ($filter_type == 'timeslot_id') {
                    $field1 = Input::get('filter_value');
                } else if ($filter_type == 'frequency_id') {
                    $field2 = Input::get('filter_value');
                } else if ($filter_type == 'amt_paid') {
                    $field3 = Input::get('filter_value');
                } else if ($filter_type == 'start_date') {
                    $field4 = Input::get('filter_value');
                    $filter_value = date("Y-m-d", strtotime(Input::get('filter_value')));
                } else if ($filter_type == 'end_date') {
                    $field5 = Input::get('filter_value');
                    $filter_value = date("Y-m-d", strtotime(Input::get('filter_value')));
                } else if ($filter_type == 'city_id') {
                    $field7 = Input::get('filter_value');
                }
                $subscription = Subscription::where('is_trial', '!=', 1)->where(Input::get('filter_type'), $filter_value)->orderBy('created_at', 'desc')->paginate(Config('constants.paginateNo'));
            }
        } else if (Input::get('filter_type') == 'renewal') {
            $filter_type = Input::get('filter_type');
            $now = Date('Y-m-d');
            $now_10days = Date('Y-m-d', strtotime($now . ' +10 day'));
            $subscription = Subscription::where('is_trial', '!=', 1)->where('end_date', '<=', $now_10days)->orderBy('created_at', 'desc')->paginate(Config('constants.paginateNo'));
        } else {
            $subscription = Subscription::where('is_trial', '!=', 1)->orderBy('created_at', 'desc')->paginate(Config('constants.paginateNo'));
        }
        Session::put('backUrl', Request::fullUrl());
        return view(Config('constants.adminSubscriptionView') . '.index', compact('subscription', 'frequency', 'timeslot', 'filter', 'filter_type', 'filter_value', 'city', 'field1', 'field2', 'field3', 'field4', 'field5', 'field6', 'field7'));
    }

    function indexTrial() {
        $f = Frequency::where("is_active", 1)->get()->toArray();
        $frequency = [];
        foreach ($f as $value) {
            $frequency[$value['id']] = $value['name'];
        }
        $cities = City::where("is_active", 1)->get()->toArray();
        $city = ['' => 'Select City'];
        foreach ($cities as $value) {
            $city[$value['id']] = $value['name'];
        }
        $t = Timeslot::where("is_active", 1)->where("type", 2)->get()->toArray();
        $timeslot = [];
        foreach ($t as $value) {
            $timeslot[$value['id']] = $value['name'];
        }
        $filter = array('' => 'All', 'renewal' => 'Due for Renewal', 'frequency_id' => 'Frequency', 'amt_paid' => 'Amount Paid', 'start_date' => 'Start Date', 'end_date' => 'End Date', 'name' => 'Subscription Name', 'city_id' => 'City');

        $filter_type = NULL;
        $filter_value = NULL;
        $field1 = NULL;
        $field2 = NULL;
        $field3 = NULL;
        $field4 = NULL;
        $field5 = NULL;
        $field6 = NULL;
        $field7 = NULL;
        if (Input::get('filter_value') && Input::get('filter_type')) {
            $filter_type = Input::get('filter_type');
            $filter_value = Input::get('filter_value');
            if ($filter_type == 'name') {
                $field6 = Input::get('filter_value');
                $subscription = Subscription::where('name', 'LIKE', "%" . Input::get('filter_value') . "%")->orderBy('created_at', 'desc')->paginate(Config('constants.paginateNo'));
            } else {
                if ($filter_type == 'timeslot_id') {
                    $field1 = Input::get('filter_value');
                } else if ($filter_type == 'frequency_id') {
                    $field2 = Input::get('filter_value');
                } else if ($filter_type == 'amt_paid') {
                    $field3 = Input::get('filter_value');
                } else if ($filter_type == 'start_date') {
                    $field4 = Input::get('filter_value');
                    $filter_value = date("Y-m-d", strtotime(Input::get('filter_value')));
                } else if ($filter_type == 'end_date') {
                    $field5 = Input::get('filter_value');
                    $filter_value = date("Y-m-d", strtotime(Input::get('filter_value')));
                }else if ($filter_type == 'city_id') {
                    $field7 = Input::get('filter_value');
                }
                $subscription = Subscription::where('is_trial', 1)->where(Input::get('filter_type'), $filter_value)->orderBy('created_at', 'desc')->paginate(Config('constants.paginateNo'));
            }
        } else if (Input::get('filter_type') == 'renewal') {
            $filter_type = Input::get('filter_type');
            $now = Date('Y-m-d');
            $now_10days = Date('Y-m-d', strtotime($now . ' +10 day'));
            $subscription = Subscription::where('is_trial', 1)->where('end_date', '<=', $now_10days)->orderBy('created_at', 'desc')->paginate(Config('constants.paginateNo'));
        } else {
            $subscription = Subscription::where('is_trial', 1)->orderBy('created_at', 'desc')->paginate(Config('constants.paginateNo'));
        }
        Session::put('backUrl', Request::fullUrl());
        return view(Config('constants.adminSubscriptionView') . '.index_trial', compact('subscription', 'frequency', 'timeslot', 'filter', 'filter_type', 'filter_value', 'city', 'field1', 'field2', 'field3', 'field4', 'field5', 'field6', 'field7'));
    }

    public function add() {
        $subscription = new Subscription();

        $userss = Role::find(2)->users->toArray();
        $users = [];
        $users = [0 => "Select a Customer"];
        foreach ($userss as $value) {
            $users[$value['id']] = $value['name'];
        }

        $occupancyd = Occupancy::where("is_active", 1)->get()->toArray();
        $occupancy = [];
        foreach ($occupancyd as $value) {
            $occupancy[$value['id']] = $value['name'];
        }

        $wastetypess = Wastetype::where("is_active", 1)->get()->toArray();
        $wastetype = [];
        foreach ($wastetypess as $value) {
            $wastetype[$value['id']] = $value['name'];
        }

        $cities = City::where("is_active", 1)->get()->toArray();
        $city = ['' => 'Select City'];
        foreach ($cities as $value) {
            $city[$value['id']] = $value['name'];
        }

        $return_of_compost = false;
        $wastetype_selected = [];
        $f = Frequency::where("is_active", 1)->get()->toArray();
        $frequency = [];
        foreach ($f as $value) {
            $frequency[$value['id']] = $value['name'];
        }

        $pack = Package::where("is_active", 1)->get()->toArray();
        $packages = [];
        foreach ($pack as $value) {
            $packages[$value['id']] = $value['name'];
        }

        $t = Timeslot::where("is_active", 1)->where("type", 2)->get()->toArray();
        $timeslot = [];
        foreach ($t as $value) {
            $timeslot[$value['id']] = $value['name'];
        }


        $action = "admin.subscription.save";
        return view(Config('constants.adminSubscriptionView') . '.addEdit', compact('subscription', 'users', 'frequency', 'timeslot', 'action', 'wastetype', 'wastetype_selected', 'packages', 'occupancy', 'return_of_compost', 'city'));
    }

    public function edit() {
        $subscription = Subscription::find(Input::get('id'));
        $userss = Role::find(2)->users->toArray();

        $users = [];
        $users = [0 => "Select a Customer"];
        foreach ($userss as $value) {
            $users[$value['id']] = $value['name'];
        }

        $wastetypess = Wastetype::where("is_active", 1)->get()->toArray();
        $wastetype = [];
        foreach ($wastetypess as $value) {
            $wastetype[$value['id']] = $value['name'];
        }

        $cities = City::where("is_active", 1)->get()->toArray();
        $city = ['' => 'Select City'];
        foreach ($cities as $value) {
            $city[$value['id']] = $value['name'];
        }

        $return_of_compost = false;
        if ($subscription->return_of_compost) {
            $return_of_compost = true;
        }

        $billing_method = false;
        if ($subscription->billing_method == 1) {
            $billing_method = true;
        }

        $occupancyd = Occupancy::where("is_active", 1)->get()->toArray();
        $occupancy = [];
        foreach ($occupancyd as $value) {
            $occupancy[$value['id']] = $value['name'];
        }

        $wastetype_selected = [];
        $wastetype_selecteds = $subscription->wastetypes->toArray();
        foreach ($wastetype_selecteds as $val)
            array_push($wastetype_selected, $val['id']);

        $f = Frequency::where("is_active", 1)->get()->toArray();
        $frequency = [];
        foreach ($f as $value) {
            $frequency[$value['id']] = $value['name'];
        }

        $pack = Package::where("is_active", 1)->get()->toArray();
        $packages = [];
        foreach ($pack as $value) {
            $packages[$value['id']] = $value['name'];
        }

        $t = Timeslot::where("is_active", 1)->get()->toArray();
        $timeslot = [];
        foreach ($t as $value) {
            $timeslot[$value['id']] = $value['name'];
        }

        $action = "admin.subscription.save";
        return view(Config('constants.adminSubscriptionView') . '.addEdit', compact('subscription', 'users', 'frequency', 'timeslot', 'action', 'wastetype', 'wastetype_selected', 'packages', 'occupancy', 'return_of_compost', 'billing_method', 'city'));
    }

    public function save() {
        $subscription = Subscription::findOrNew(Input::get('id'));
        $subscription->fill(Input::except('wastetype', 'att'))->save();
        $subscription->wastetypes()->sync(Input::get('wastetype'));
        foreach (Input::file('att') as $key => $att) {
            if ($att) {
                $destinationPath = public_path() . '/uploads/records/';
                $fileName = time() . $key . '.' . $att->getClientOriginalExtension();
                if ($att->move($destinationPath, $fileName)) {
                    Attachment::create(['subscription_id' => $subscription->id, 'file' => $fileName, 'filename' => $att->getClientOriginalName(), 'is_active' => 1, "added_by" => Input::get("added_by")]);
                }
            }
        }
        return redirect()->to(Session::get('backUrl'));
    }

    public function delete() {
        $subscription = Subscription::find(Input::get('id'));
        $subscription->delete();
        Pickup::where('subscription_id', Input::get('id'))->delete();
        return redirect()->back()->with("message", "Subscription deleted successfully");
    }

    public function rmfile() {
        $atta = Attachment::find(Input::get('id'));
        $atta->is_active = '0';
        $atta->save();
        return redirect()->back()->with("message", "Attachment Removed successfully");
        exit();
    }

}
