@php use Carbon\Carbon; @endphp
<footer class="main-footer {{config('aim-admin.layout_class.footer', '')}}">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        {{config('aim-admin.footer_text', 'Anything you want')}}
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-{{Carbon::now()->format('Y')}} <a
            href="https://codecoz.com/en">{{env('APP_NAME')}}</a>.</strong> All rights
    reserved.
</footer>
