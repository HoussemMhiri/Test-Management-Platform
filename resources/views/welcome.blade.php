<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>
            <link rel="stylesheet" type="text/css" href="{{ asset('css/semantic.min.css') }}">

    </head>
    <body>
        {{ trans('common.test') }}
        {{ __('common.test') }}
        <hr>

        @lang('common.test')

        <div id="app">
            <test/>
        </div>

        <div class="fomantic">
            <div class="ui segment">
                <div class="ui blue message">
                    hello world <em data-emoji=":cupid:"></em><br>
                    <select class="ui dropdown clearable search">
                        <option>hello</option>
                        <option>hello2</option>
                        <option>hello3</option>
                        <option>hello4</option>
                    </select>
                    <i class="arrow right icon"></i>
                </div>
            </div>
        </div>



        <script src="{{ mix('js/app.js') }}"></script>

        <script src="{{ asset('js/semantic.min.js') }}"></script>
        <script>
            $(document).ready(function(){
                $('.ui.dropdown') .dropdown();
            });
        </script>

        <!--    ckeditor     -->
{{--        <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>--}}
        <script>
            // ClassicEditor.create(document.querySelector('#editor'))
            //     .catch(error => {
            //         console.log('error')
            //     })
        </script>
    </body>
</html>
