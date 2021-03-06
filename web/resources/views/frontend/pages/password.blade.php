@extends('frontend.layouts.site')
@section('content')

<!-- <section id="page-title" style="background:none;">
            <div class="container clearfix">
                <h1>Profile</h1>
                <br>
                 <p>Your Account Information</p>
            </div>

        </section> -->

<!-- <section id="slider" class="slider-parallax loginsec" data-height-lg="300" data-height-md="500" data-height-sm="250px" data-height-xs="250" data-height-xxs="200">
    <div class="slider-parallax-inner">
        <div class="container clearfix">
            <div class="vertical-middle">

                <div class="heading-block nobottomborder">
                    <h1>
                        <div>
                            <span>Profile</span>
                        </div>
                    </h1>
                     <p>Your Account Information</p>
                </div>

            </div>
        </div>
    </div>
</section> -->

<section id="content">
    <div class="content-wrap">
        <div class="flash-message green">
            {{Session::pull('profileSuccess')}} 
        </div>
        <div class="flash-message red">
            {{Session::pull('ProfileError')}}                            
        </div>
        <div class="container clearfix">
            <div class="sidebar nobottommargin">
                <div class="sidebar-widgets-wrap">
                    <div class="widget clearfix">
                        <div class="fancy-title title-bottom-border">
                            <h3>{{ @$user->subscriptions()->first()->name }}</h3>
                        </div>
                        <div id="headsub">
                            <ul class="icons iconlist-large iconlist-color">
<!--                                <li><a href="{{route('user.myaccount.view')}}">Service Summary</a></li>
                                <li><a href="{{route('user.subscription.view')}}">My Subscription</a></li>
                                <li><a href="{{route('user.payment.info')}}">Payment Info</a></li>-->
                                <li><a href="{{route('user.myprofile.view')}}">My Profile</a></li>
                                <li class="actives"><a href="{{route('user.mypassword.view')}}">Change Password</a></li>
                            </ul>

                        </div>
                    </div>

                </div>
            </div>

            <div class="postcontent col_last nobottommargin">

                <!-- Portfolio Single Image
                ============================================= -->
                <div class="col_full portfolio-single-image">
                    <div class="fancy-title title-bottom-border">
                        <h3>Change Password</h3>
                    </div>
                    <div class="">  
                        {!! Form::model($user, ['method' => 'post', 'route' => $action , 'class' => 'nobottommargin' ]) !!}
                        <div class="form-process"></div>

                        <div class="col_one_third">
                            <label for="old-password">Old Password:</label>
                            {!! Form::text('old_password',null, ["class"=>"sm-form-control validate[required]" ,"placeholder"=>"Old Password"]) !!}
                        </div>


                        <div class="col_one_third">
                            <label for="password">New Password:</label>
                            {!! Form::text('new_password',null, ["class"=>"sm-form-control validate[required]", "id"=>"new_password" ,"placeholder"=>"New Password"]) !!}
                        </div>

                        <div class="col_one_third col_last">
                            <label for="confirm-password">Reenter New Password:</label>
                            {!! Form::text('confirm_password',null, ["class"=>"sm-form-control validate[required, equals[new_password]]"  ,"placeholder"=>"Reenter New Password", ]) !!}
                        </div>
                        <div class="clear"></div>

                        <center>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <button type="submit" class="button button-3d button-black nomargin">Submit</button>
                            </div>
                        </center>
                        {!! Form::hidden('id',null) !!}
                        {!! Form::close() !!}  

                    </div>
                </div><!-- .portfolio-single-image end -->
                <div class="clear"></div>
            </div>
        </div>

    </div>

</section><!-- #content end -->

@stop