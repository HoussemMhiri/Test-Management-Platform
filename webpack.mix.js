const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/js")
    .vue()
    .postCss("resources/css/app.css", "public/css", [
        //
    ])
    .copy("resources/images", "public/images")
    .css("resources/css/auth/login.css", "public/css/auth/login.css")
    .copy("semantic/dist/semantic.min.css", "public/css/semantic.min.css")
    .copy("semantic/dist/semantic.min.js", "public/js/semantic.min.js")
    .copy("semantic/dist/themes", "public/css/themes")
    .js("resources/js/modules/tests/index.js", "public/js/modules/tests")
    .js("resources/js/modules/tests/create.js", "public/js/modules/tests")
    .js(
        "resources/js/modules/tests/attempts/attempts.js",
        "public/js/modules/tests/attempts"
    )
    .js(
        "resources/js/modules/tests/exams/exams.js",
        "public/js/modules/tests/exams"
    )
    .js(
        "resources/js/modules/tests/invitations/invitations.js",
        "public/js/modules/tests/invitations"
    )
    .js("resources/js/modules/tests/edit.js", "public/js/modules/tests")
    .js("resources/js/auth/login.js", "public/js/auth")
    .js("resources/js/site/testimonials.js", "public/js/site")
    .js("resources/js/layouts/app/base.js", "public/js/layouts/app")
    .js("resources/js/modules/users/edit.js", "public/js/modules/users")
    .js(
        "resources/js/modules/tests/sessions/session.js",
        "public/js/modules/tests/sessions"
    )
    .js("resources/js/access_code/access-code.js", "public/js/access_code")
    .js(
        "resources/js/accept_invitation/accept_invitation.js",
        "public/js/accept_invitation"
    )
    .js(
        "resources/js/subscription_plans/subscription_plans.js",
        "public/js/subscription_plans"
    )
    .js(
        "resources/js/upgrade_plans/upgrade_plans.js",
        "public/js/upgrade_plans"
    )
    .js("resources/js/payment/payment.js", "public/js/payment")
    .js("resources/js/payment/success.js", "public/js/payment");


