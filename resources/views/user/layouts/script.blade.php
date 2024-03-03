<!-- js file  -->
<script src="{{ asset('user/js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ asset('user/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('user/js/plugins.js') }}"></script>
<script src="{{ asset('user/js/dataTables.js') }}"></script>
<script src="{{ asset('user/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('user/css/summernote/summernote-lite.min.js') }}"></script>
<script src="{{ asset('user/js/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('user/js/apexcharts.min.js') }}"></script>
<script src="{{ asset('user/js/main.js') }}"></script>
<script src="{{ asset('common/js/common.js') }}"></script>

@stack('script')

<script>
    $("#topBannerClose").on('click', function() {
        $(this).parent().remove();
    });
    var currencySymbol = "{{ getCurrencySymbol() }}";
    var currencyPlacement = "{{ getCurrencyPlacement() }}";

    @if (Session::has('success'))
        toastr.success("{{ session('success') }}");
    @endif
    @if (Session::has('error'))
        toastr.error("{{ session('error') }}");
    @endif
    @if (Session::has('info'))
        toastr.info("{{ session('info') }}");
    @endif
    @if (Session::has('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif

    @if (@$errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>
