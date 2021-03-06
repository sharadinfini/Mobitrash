<?php ?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">

        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class=" {{ preg_match("/admin.dashboard/",Route::currentRouteName())? 'active' : ''}}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-bar-chart"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class=" {{ preg_match("/admin.schedule.view/",Route::currentRouteName())? 'active' : ''}}">
                <a href="{{ route('admin.schedule.view') }}">
                    <i class="fa fa-clock-o"></i>
                    <span>Schedule Management</span>
                </a>
            </li>
            <li class=" {{ preg_match("/admin.servicehistory.view/",Route::currentRouteName())? 'active' : ''}}">
                <a href="{{ route('admin.servicehistory.view') }}">
                    <i class="fa fa-history"></i>
                    <span>Service History</span>
                </a>
            </li>
            <li class=" {{ preg_match("/admin.subscription.view|admin.subscription.trial/",Route::currentRouteName())? 'active' : ''}}">
                <a href="">
                    <i class="fa fa-user-plus"></i>
                    <span>User Subscriptions</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.subscription.view/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.subscription.view') }}"><i class="fa fa-user-plus"></i>All Subscriptions</a></li>
                    <li class="{{ preg_match("/admin.subscription.trial/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.subscription.trial') }}"><i class="fa fa-calendar-check-o"></i>Trial Subscriptions</a></li>

                </ul>
            </li>  
            <li class=" {{ preg_match("/admin.assets.view/",Route::currentRouteName())? 'active' : ''}}">
                <a href="{{ route('admin.assets.view') }}">
                    <i class="fa fa-suitcase"></i>
                    <span>Assets Management</span>
                </a>
            </li>

            <li class=" {{ preg_match("/admin.record.view/",Route::currentRouteName())? 'active' : ''}}">
                <a href="{{ route('admin.record.view') }}">
                    <i class="fa fa-list-alt"></i>
                    <span>Record Management</span>
                </a>
            </li>

            <li class=" {{ preg_match("/admin.payment.view/",Route::currentRouteName())? 'active' : ''}}">
                <a href="{{ route('admin.payment.view') }}">
                    <i class="fa fa-money"></i>
                    <span>Payment Management</span>
                </a>
            </li>

            <li class=" {{ preg_match("/admin.attendance.view/",Route::currentRouteName())? 'active' : ''}}">
                <a href="{{ route('admin.attendance.view') }}">
                    <i class="fa fa-check-square"></i>
                    <span>Attendance Management</span>
                </a>
            </li>
            <li class="treeview {{ preg_match("/admin.gardenwaste.view|admin.gardenwaste.pickupslot|admin.gardenwaste.setting|admin.gardenwaste.messages|admin.gunnyorder.view/",Route::currentRouteName())? 'active' : ''}}">
                <a href="#">
                    <i class="fa fa-leaf"></i>
                    <span>Garden Waste Management</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.gardenwaste.view/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.gardenwaste.view') }}"><i class="fa fa-pagelines"></i>Garden Waste</a></li>
                    <li class="{{ preg_match("/admin.gardenwaste.pickupslot/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.gardenwaste.pickupslot') }}"><i class="fa fa-calendar"></i>Manage Pickup Slots</a></li>
                    <li class="{{ preg_match("/admin.gardenwaste.setting/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.gardenwaste.setting') }}"><i class="fa fa-cogs"></i>Garden Waste Setting</a></li>
                    <li class="{{ preg_match("/admin.gardenwaste.messages/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.gardenwaste.messages') }}"><i class="fa fa-envelope"></i>Customers Messages</a></li>
                    <li class="{{ preg_match("/admin.gunnyorder.view/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.gunnyorder.view') }}"><i class="fa fa-square-o"></i>Empty Gunny Orders</a></li>
                </ul>
            </li>
            <li class=" {{ preg_match("/admin.bonfleet.view/",Route::currentRouteName())? 'active' : ''}}">
                <a href="{{ route('admin.bonfleet.view') }}">
                    <i class="fa fa-check-square"></i>
                    <span>Bonfleet</span>
                </a>
            </li>

            <li class="treeview {{ preg_match("/admin.roles.view|admin.systemusers.view|admin.users.view/",Route::currentRouteName())? 'active' : ''}}">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>User Management</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.roles.view/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.roles.view') }}"><i class="fa fa-user-secret"></i>Roles</a></li>
                    <li class="{{ preg_match("/admin.systemusers.view/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.systemusers.view') }}"><i class="fa fa-user"></i>System Users</a></li>
                    <li class="{{ preg_match("/admin.users.view/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.users.view') }}"><i class="fa fa-users"></i>Customers</a></li>
                </ul>
            </li>
            <li class="treeview {{ preg_match("/admin.gallery.view/",Route::currentRouteName())? 'active' : ''}}">
                <a href="{{ route('admin.gallery.view') }}">
                    <i class="fa fa-picture-o"></i>
                    <span>Gallery</span>
                </a>
            </li>

            <li class="treeview {{ preg_match("/admin.cities.view|admin.frequency.view|admin.additive.view|admin.fueltype.view|admin.wastetype.view|admin.recordtype.view|admin.occupancy.view|admin.timeslot.view|admin.servicetype.view/",Route::currentRouteName())? 'active' : ''}}">
                <a href="#">
                    <i class="fa fa-clipboard"></i>
                    <span>Masters</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.cities.view/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.cities.view') }}"><i class="fa fa-building-o"></i>Cities</a></li>
                    <li class="{{ preg_match("/admin.frequency.view/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.frequency.view') }}"><i class="fa fa-tasks"></i>Frequency</a></li>
                    <!--<li class="{{ preg_match("/admin.timeslot.view/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.timeslot.view') }}"><i class="fa fa-calendar"></i>Timeslot</a></li>-->
                    <!--<li class="{{ preg_match("/admin.servicetype.view/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.servicetype.view') }}"><i class="fa fa-circle-o"></i>Servicetype</a></li>-->
                    <li class="{{ preg_match("/admin.wastetype.view/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.wastetype.view') }}"><i class="fa fa-trash"></i>Wastetype</a></li>
                    <li class="{{ preg_match("/admin.fueltype.view/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.fueltype.view') }}"><i class="fa fa-truck"></i>Fueltype</a></li>
                    <li class="{{ preg_match("/admin.additive.view/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.additive.view') }}"><i class="fa fa-circle-o"></i>Additive</a></li>
                    <li class="{{ preg_match("/admin.recordtype.view/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.recordtype.view') }}"><i class="fa fa-file-o"></i>Recordtype</a></li>
                    <!--<li class="{{ preg_match("/admin.package.view/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.package.view') }}"><i class="fa fa-archive"></i>Package</a></li>-->
                    <li class="{{ preg_match("/admin.recordtype.view/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.occupancy.view') }}"><i class="fa fa-check-circle"></i>Occupancy</a></li>
                    <li class="{{ preg_match("/admin.shift.view/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.shift.view') }}"><i class="fa fa-calendar"></i>Shift</a></li>


                </ul>
            </li>




        </ul>
    </section>
    <!-- /.sidebar -->
</aside>