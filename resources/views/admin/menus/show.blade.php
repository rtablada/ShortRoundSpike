@extends('admin.layouts.sb-wrapper')

@section('page')
    <div id="menus-app" class="row">
    </div>
@endsection

@section('head')
<meta name="shortround-menus/config/environment" content="%7B%22rootElement%22%3A%22%23menus-app%22%2C%22modulePrefix%22%3A%22shortround-menus%22%2C%22environment%22%3A%22development%22%2C%22baseURL%22%3A%22/%22%2C%22locationType%22%3A%22none%22%2C%22EmberENV%22%3A%7B%22FEATURES%22%3A%7B%7D%7D%2C%22APP%22%3A%7B%7D%2C%22contentSecurityPolicyHeader%22%3A%22Content-Security-Policy-Report-Only%22%2C%22contentSecurityPolicy%22%3A%7B%22default-src%22%3A%22%27none%27%22%2C%22script-src%22%3A%22%27self%27%20%27unsafe-eval%27%22%2C%22font-src%22%3A%22%27self%27%22%2C%22connect-src%22%3A%22%27self%27%22%2C%22img-src%22%3A%22%27self%27%22%2C%22style-src%22%3A%22%27self%27%22%2C%22media-src%22%3A%22%27self%27%22%7D%2C%22exportApplicationGlobal%22%3Atrue%7D" />

@append

@section('scripts')
<script>
window.parent = <?= $parent->toJson() ?>;
window.menus = <?= $menus->toJson() ?>;
</script>
<script src="/js/menu-app.js"></script>
@append
