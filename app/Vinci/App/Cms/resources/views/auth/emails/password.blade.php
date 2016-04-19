Click here to reset your password: <a href="{{ $link = url('cms/password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
