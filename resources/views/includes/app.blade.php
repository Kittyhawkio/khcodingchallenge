<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flights</title>
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    @stack('styles')
</head>
<body>
    <header class="z-50 flex bg-indigo-600 text-white border-b border-gray-400 fixed top-0 inset-x-0 z-100 h-16 items-center">
        <nav class="w-5/6 xl:w-full max-w-screen-xl relative mx-auto">
            <div class="flex items-center justify-between">
                <h1 class="py-2 text-2xl">
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            viewBox="0 0 512 512" class="fill-current inline-block w-10" xml:space="preserve">
                        <g>
                            <g>
                                <path d="M422,332c-19.406,0-37.277,6.313-51.991,16.798l-13.326-13.326c-33.889-46.329-33.889-112.614,0-158.943l13.326-13.327
                                    C384.723,173.687,402.594,180,422,180c49.629,0,90-40.371,90-90c0-49.629-40.371-90-90-90c-49.629,0-90,40.371-90,90
                                    c0,19.406,6.313,37.277,16.798,51.991l-13.328,13.328c-46.344,33.904-112.596,33.904-158.94,0l-13.328-13.328
                                    C173.687,127.277,180,109.406,180,90c0-49.629-40.371-90-90-90C40.371,0,0,40.371,0,90c0,49.629,40.371,90,90,90
                                    c19.406,0,37.277-6.313,51.991-16.798l13.326,13.326c33.889,46.329,33.889,112.614,0,158.943l-13.326,13.326
                                    C127.277,338.313,109.406,332,90,332c-49.629,0-90,40.371-90,90c0,49.629,40.371,90,90,90s90-40.371,90-90
                                    c0-19.406-6.313-37.277-16.798-51.991l13.328-13.328c46.344-33.904,112.596-33.904,158.94,0l13.328,13.328
                                    C338.313,384.723,332,402.594,332,422c0,49.629,40.371,90,90,90c49.629,0,90-40.371,90-90C512,372.371,471.629,332,422,332z
                                    M422,30c33.091,0,60,26.909,60,60s-26.909,60-60,60c-11.094,0-21.367-3.232-30.289-8.5L422,111.211l4.395,4.395
                                    c5.859,5.859,15.352,5.859,21.211,0c5.859-5.859,5.859-15.352,0-21.211l-30-30c-5.859-5.859-15.352-5.859-21.211,0
                                    c-5.859,5.859-5.859,15.352,0,21.211L400.789,90L370.5,120.289c-5.268-8.923-8.5-19.195-8.5-30.289C362,56.909,388.909,30,422,30z
                                    M141.5,120.289L111.211,90l4.395-4.395c5.859-5.859,5.859-15.352,0-21.211s-15.352-5.859-21.211,0l-30,30
                                    c-5.859,5.859-5.859,15.352,0,21.211s15.352,5.859,21.211,0L90,111.211l30.289,30.289c-8.923,5.268-19.195,8.5-30.289,8.5
                                    c-33.091,0-60-26.909-60-60s26.909-60,60-60s60,26.909,60,60C150,101.094,146.768,111.367,141.5,120.289z M90,482
                                    c-33.091,0-60-26.909-60-60s26.909-60,60-60c11.094,0,21.367,3.232,30.289,8.5L90,400.789l-4.395-4.395
                                    c-5.859-5.859-15.352-5.859-21.211,0c-5.859,5.859-5.859,15.352,0,21.211l30,30c5.859,5.859,15.352,5.859,21.211,0
                                    c5.859-5.859,5.859-15.352,0-21.211L111.211,422l30.289-30.289c5.268,8.923,8.5,19.195,8.5,30.289C150,455.091,123.091,482,90,482
                                    z M422,482c-33.091,0-60-26.909-60-60c0-11.094,3.232-21.367,8.5-30.289L400.789,422l-4.395,4.395
                                    c-5.859,5.859-5.859,15.352,0,21.211c2.93,2.93,6.768,4.395,10.605,4.395c3.837,0,7.676-1.465,10.605-4.395l30-30
                                    c5.859-5.859,5.859-15.352,0-21.211s-15.352-5.859-21.211,0L422,400.789L391.711,370.5c8.923-5.268,19.195-8.5,30.289-8.5
                                    c33.091,0,60,26.909,60,60S455.091,482,422,482z"/>
                            </g>
                        </g>
                    </svg>
                    <span class="hidden md:inline-block">
                    &nbsp;&nbsp;Drone Flight Planner
                    </span>
                </h1>
                <ul>
                    <a class="hover:text-indigo-200" href="/flights">
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current inline-block w-5" viewBox="0 0 20 20"><path d="M1 4h2v2H1V4zm4 0h14v2H5V4zM1 9h2v2H1V9zm4 0h14v2H5V9zm-4 5h2v2H1v-2zm4 0h14v2H5v-2z"/></svg>
                        Flights
                    </a>
                </ul>
            </div>
        </nav>
    </header>


    <div class="w-full min-h-1/2 bg-gray-200" id="#app">
        <div class="pt-16 md:py-24 min-h-screen w-full lg:static lg:max-h-full lg:overflow-visible mx-auto">
            @yield('content')
        </div>
    </div>


    <footer class="flex flex-col md:flex-row bg-white border-t border-gray-400 relative lg:fixed bottom-0 inset-x-0 z-100 h-16 items-center justify-around">
        <div>
            Created by <a class="text-indigo-600 hover:text-indigo-400" href="https://clardy.eu">Marisa Clardy</a> for <a class="text-indigo-600 hover:text-indigo-400" href="https://kittyhawk.io">Kittyhawk</a>
        </div>
        <div>
            <small class="text-xs block">
                Drone Icon by <a class="text-indigo-600 hover:text-indigo-400" href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a class="text-indigo-600 hover:text-indigo-400" href="https://www.flaticon.com/" title="Flaticon">flaticon.com</a>
            </small>
            <small class="text-xs block">
                Other icons by <a class="text-indigo-600 hover:text-indigo-400" href="http://www.zondicons.com/" title="Zondicons">Zondicons</a>
            </small>
        </div>
    </footer>

    @stack('scripts')
    <script src="/js/app.js" defer></script>
</body>
</html>
