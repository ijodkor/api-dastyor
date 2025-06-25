@use(Ijodkor\Dastyor\Boot\Boot)
<!doctype html>
<html lang="{{ app()->getLocale() }}" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <title>@yield('title')</title>
    {{ Boot::css() }}
    @livewireStyles
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <div class="layout-page">
                @include(Boot::getView('layouts.navbar'))
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <small class="text-light fw-medium">Dastyorlar</small>
                            <div class="bs-stepper vertical wizard-modern w-100">
                                @include(Boot::getView('layouts.menu'))
                                <div class="bs-dark-stepper-content w-100">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                    @include(Boot::getView('layouts.footer'))
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>
    {{ Boot::js() }}
    @stack('js')
    @livewireScripts
</body>
</html>
