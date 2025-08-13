<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sistem Informasi Rajawali II</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style>
        body {
            background: url('<?= base_url(); ?>assets/background.png') no-repeat center center;
            background-size: cover;
            font-family: 'Inter', sans-serif;
        }

        .backdrop-blur {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.65);
        }

        input::placeholder {
            font-style: italic;
            color: #9ca3af;
        }
    </style>
    <script>
        var site_url = "<?= site_url() ?>";
    </script>
</head>

<body class="min-h-screen bg-cover bg-center bg-no-repeat flex items-center justify-center px-4 overflow-x-hidden">
    <div class="flex flex-col justify-center min-h-screen w-full">
        <main class="mx-auto backdrop-blur rounded-xl max-w-md w-full p-8 shadow-lg text-gray-800 bg-white/70">
            <header class="mb-8 text-center">
                <div class="mx-auto mb-3 w-40 h-25">
                    <img src="<?= base_url(); ?>assets/logo-header.png" alt="ID FOOD" class="w-full h-full object-contain" />
                </div>
            </header>


            <form class="form-horizontal">
                <label for="t_username" class="block mb-1 text-sm font-medium">Username</label>
                <div class="relative mb-6">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9 9 0 1118.879 6.196 9 9 0 015.121 17.804z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </span>
                    <input
                        id="t_username"
                        name="t_username"
                        type="text"
                        placeholder="Masukkan username"
                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-600"
                        autocomplete="username" />
                </div>

                <label for="t_password" class="block mb-1 text-sm font-medium">Password</label>
                <div class="relative mb-8">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m0-6v2m6 4H6a2 2 0 01-2-2V9a2 2 0 012-2h4l2-3 2 3h4a2 2 0 012 2v4a2 2 0 01-2 2z" />
                        </svg>
                    </span>
                    <input
                        id="t_password"
                        name="t_password"
                        type="password"
                        placeholder="Masukkan password"
                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                        autocomplete="current-password" />
                </div>

                <!-- <div class="mb-6">
                    <label class="block mb-1 text-sm font-medium">CAPTCHA</label>
                    <div class="g-recaptcha" data-sitekey="6LcZN9IqAAAAADKkvCxK2Je6zQ_pHl9H6Vaw21qY"></div>
                </div> -->

                <div id="error_cont" class="mb-4 text-sm text-red-600 hidden">
                    <span id="error_message_cont"></span>
                </div>

                <a href="javascript:void(0);"
                    class="w-full bg-gray-900 text-white font-semibold py-3 rounded-md hover:bg-gray-800 transition flex justify-center items-center gap-2" onclick="login();">
                    LOG IN
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <div class="mt-4 text-center">
                    <a href="/lupa_password" class="text-sm text-blue-600 hover:underline">Lupa password?</a>
                </div>


            </form>

            <footer class="mt-10 text-center text-xs text-gray-500 select-none">
                <div class="flex justify-center items-center space-x-2">
                    <img src="/assets/logo-foot.png" alt="Rajawali II" class="h-14 max-w-full object-contain">
                </div>
            </footer>

        </main>
    </div>

    <!-- jQuery -->
    <script src="<?= base_url(); ?>assets/assets_ui/libs/jquery/jquery.min.js"></script>

    <script type="text/javascript">
        function login() {
            $('#error_message_cont').html('');
            $('#error_cont').hide();
            $.post(site_url + "login/signin", {
                t_username: $('#t_username').val(),
                t_password: $('#t_password').val()
                // ,'g-recaptcha-response': grecaptcha.getResponse()
            }, function(result) {
                if (result.error) {
                    $('#error_message_cont').html(result.error);
                    $('#error_cont').show();
                } else {
                    window.location = site_url;
                }
            }, "json");
        }
    </script>
</body>

</html>