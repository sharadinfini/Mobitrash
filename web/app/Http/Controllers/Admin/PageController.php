<?php

namespace App\Http\Controllers\Admin;

use Route;
use Illuminate\Support\Facades\Input;
use App\Models\Asset;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Service;
use App\Models\VanLocation;
use App\Models\Schedule;
use App\Models\Payment;
use App\Models\Wastetype;
use App\Models\Configuration;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Session;

class PageController extends Controller {

    public function dashboard() {
        $current_week_start = Date('Y-m-d', strtotime('previous monday'));
        $current_week_end = Date('Y-m-d', strtotime('next sunday'));
        $last_week_start = Date('Y-m-d', strtotime($current_week_start . ' -7 day'));
        $last_week_end = Date('Y-m-d', strtotime($current_week_end . ' -7 day'));
        $current_month['start'] = Date('Y-m-01');
        $current_month['end'] = Date('Y-m-t');
        $last_month['start'] = date('Y-m-d', strtotime('first day of last month'));
        $last_month['end'] = date('Y-m-d', strtotime('last day of last month'));
        $subscription['current_week'] = Subscription::where('start_date', '>=', $current_week_start)->where('start_date', '<=', $current_week_end)->count();
        $subscription['last_week'] = Subscription::where('start_date', '>=', $last_week_start)->where('start_date', '<=', $last_week_end)->count();
        $subscription['current_month'] = Subscription::where('start_date', '>=', $current_month['start'])->where('start_date', '<=', $current_month['end'])->count();
        $pending_payment['current_month'] = Payment::where(function($query)use ($current_month) {
                    $query->where('invoice_date', '>=', $current_month['start']);
                    $query->where('invoice_date', '<=', $current_month['end']);
                    $query->where('payment_made', 0);
                })->orWhere(function($query) {
                    $query->where('invoice_month', Date('Y-m'));
                    $query->where('payment_made', 0);
                })->count();
        $pending_payment['last_month'] = Payment::where(function($query)use ($last_month) {
                    $query->where('invoice_date', '>=', $last_month['start']);
                    $query->where('invoice_date', '<=', $last_month['end']);
                    $query->where('payment_made', 0);
                })->orWhere(function($query) {
                    $query->where('invoice_month', date('Y-m', strtotime(date('Y-m') . " -1 month")));
                    $query->where('payment_made', 0);
                })->count();

        $vans = Asset::where("is_active", 1)->where("type_id", 1)->whereHas('schedules', function($q) {
                    $q->where('for', date('Y-m-d'));
                })->with(['schedules' => function($q) {
                        $q->where('for', date('Y-m-d'))->orderBy("sort_order", 'asc');
                    }])->get()->toArray();

        $services = Service::where('created_at', 'LIKE', "%" . date('Y-m-d') . "%")->get(['pickup_id']);
        $pickupids = array(); //        
        foreach ($services as $service) {
            array_push($pickupids, $service->pickup_id);
        }

        foreach ($vans as $key => $van) {
            foreach ($van['schedules'] as $key1 => $schedule) {
                if ($schedule) {
                    foreach ($schedule['pickups'] as $pkey => $pickup) {
                        if (in_array($pickup['id'], $pickupids)) {
                            $vans[$key]['schedules'][$key1]['pickups'][$pkey]['isPicked'] = true;
                        } else {
                            $vans[$key]['schedules'][$key1]['pickups'][$pkey]['isPicked'] = false;
                        }
                    }
                }
            }
        }
        $monthly_sub_amt = Payment::where('billing_method', 1)->where('invoice_month', date('Y-m'))->sum('invoice_amount');

        $waste_till_date_sum = 0;

        $allwastes = array();
        $waste_till_date = Service::with('wastetypes')->get()->toArray();
        foreach ($waste_till_date as $totalwaste) {
            foreach ($totalwaste['wastetypes'] as $key => $wastetype) {
                $allwastes[$wastetype['id']]['id'] = $wastetype['id'];
                $allwastes[$wastetype['id']]['name'] = $wastetype['name'];
                if (isset($allwastes[$wastetype['id']]['total_quantity'])) {
                    $allwastes[$wastetype['id']]['total_quantity'] += $wastetype['pivot']['quantity'];
                } else {
                    $allwastes[$wastetype['id']]['total_quantity'] = $wastetype['pivot']['quantity'];
                }
                $waste_till_date_sum = $waste_till_date_sum + $wastetype['pivot']['quantity'];
            }
        }

        $wastes = array();
        $totalwastes = Service::where('created_at', 'LIKE', date('Y-m-d') . "%")->with('wastetypes')->get()->toArray();
        foreach ($totalwastes as $totalwaste) {
            foreach ($totalwaste['wastetypes'] as $key => $wastetype) {
                $wastes[$wastetype['id']]['id'] = $wastetype['id'];
                $wastes[$wastetype['id']]['name'] = $wastetype['name'];
                if (isset($wastes[$wastetype['id']]['total_quantity'])) {
                    $wastes[$wastetype['id']]['total_quantity'] += $wastetype['pivot']['quantity'];
                } else {
                    $wastes[$wastetype['id']]['total_quantity'] = $wastetype['pivot']['quantity'];
                }
            }
        }
        $additives = array();
        $totaladditives = Service::where('created_at', 'LIKE', date('Y-m-d') . "%")->with('additives')->get()->toArray();
        foreach ($totaladditives as $totaladditive) {
            foreach ($totaladditive['additives'] as $key => $additive) {
                $additives[$additive['id']]['id'] = $additive['id'];
                $additives[$additive['id']]['name'] = $additive['name'];
                if (isset($additives[$additive['id']]['total_quantity'])) {
                    $additives[$additive['id']]['total_quantity'] += $additive['pivot']['quantity'];
                } else {
                    $additives[$additive['id']]['total_quantity'] = $additive['pivot']['quantity'];
                }
            }
        }

        $pia_colors = ['#F15854', '#5DA5DA', '#60BD68', '#FAA43A', '#F17CB0', '#B2912F', '#B276B2', '#DECF3F', '#00FF66', '#5668E2', '#3B3178', '#3B5323'];
        $cnt = 0;
        foreach ($allwastes as $key => $waste) {
            $allwastes[$key]['color'] = $pia_colors[$cnt];
            $cnt++;
        }
        $cnt = 0;
        foreach ($wastes as $key => $waste) {
            $wastes[$key]['color'] = $pia_colors[$cnt];
            $cnt++;
        }
        $cnt = 0;
        foreach ($additives as $key => $additive) {
            $additives[$key]['color'] = $pia_colors[$cnt];
            $cnt++;
        }
        return view(Config('constants.adminView') . '.dashboard', compact(['subscription', 'pending_payment', 'vans', 'monthly_sub_amt', 'allwastes', 'wastes', 'additives', 'waste_till_date_sum']));
    }

    public function setting() {
        $configuration = Configuration::find(1);
        $action = "admin.settings.save";
        return view(Config('constants.adminView') . '.setting', compact(['configuration', 'action']));
    }

    public function settingsSave() {
        $configuration = Configuration::findOrNew(Input::get('id'))->fill(Input::all())->save();
        Session::flash('messageSuccess', "Settings Updated Successfully!");
        return redirect()->route('admin.settings');
    }

    public function vanLocationMap() {
        $schedules = Schedule::where('van_id', Input::get('id'))->where('for', date('Y-m-d'))->get();
        $van = Asset::find(Input::get('id'));
        $locations = $van->vanlocation->toArray();
        $pickups = [];
        foreach ($schedules as $schedule) {
            $sch = $schedule->pickups()->with('user', 'subscription.address')->get()->toArray();
            foreach ($schedule['pickups'] as $pickup) {
                array_push($pickups, $pickup);
            }
        }
        return view(Config('constants.adminView') . '.map', compact(['schedule', 'locations', 'pickups', 'van']));
    }

    public function vanLocationGet() {
        $locations = VanLocation::where('van_id', Input::get('id'))->orderBy('created_at', 'desc')->first()->toArray();
        return $locations;
    }

}
