<!DOCTYPE html>
<html lang="en">
<head>
    <script defer src="https://umami.coolify-apps.hirodiscount.com/script.js" data-website-id="4ed22cf8-528b-4aa1-a549-5d16dd6e277b"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create a secret</title>
    @vite('resources/css/app.css')

    <style>
        .bg{
    background-image: url('/bg.jpg');
    @apply bg-cover bg-center;
}

</style>
</head>
<body class="bg min-h-screen h-full">

<div class="p-8 min-h-screen h-full bg-white/20 ">
    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-sm text-red-800 rounded-lg p-4 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500" role="alert">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="flex-shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"></circle>
              <path d="m15 9-6 6"></path>
              <path d="m9 9 6 6"></path>
            </svg>
          </div>
          <div class="ms-4">
            <h3 class="text-sm font-semibold">
              A problem has been occurred while submitting your data.
            </h3>
            <div class="mt-2 text-sm text-red-700 dark:text-red-400">
              <ul class="list-disc space-y-1 ps-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
@endif


@if(session('success'))
<div class="bg-green-50 border-t-2 border-green-500 rounded-lg p-4 dark:bg-green-800/30" role="alert">
    <div class="flex">
      <div class="flex-shrink-0">
        <!-- Icon -->
        <span class="inline-flex justify-center items-center size-8 rounded-full border-4 border-green-100 bg-green-200 text-green-800 dark:border-green-900 dark:bg-green-800 dark:text-green-400">
          <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
            <path d="m9 12 2 2 4-4"></path>
          </svg>
        </span>
        <!-- End Icon -->
      </div>
      <div class="ms-3">
        <h3 class="text-gray-800 font-semibold dark:text-white">
          {{ session('success') }}
        </h3>
      </div>
    </div>
  </div>
@endif
    <form class="flex justify-center mt-8" method="POST" action="{{ route('secret.store') }}">
        @csrf
        <div class="card w-96 p-8 border border-base-content/20 bg-base-100/70 backdrop-blur-sm  shadow-xl">
            <h1 class="text-xl font-bold text-center">Create a new secret</h1>

           <div class="mt-8 flex flex-col">
            <label for="content ">Enter your secret</label>
            <textarea  name="content" class="textarea textarea-bordered mt-2 focus:outline-primary" required placeholder="Password: MySecretPassword"></textarea>
           </div>

            <label for="receivers" class="mt-4">Share with</label>
            <textarea name="receivers" class="textarea textarea-bordered mt-2 focus:outline-primary" required  placeholder="email@domain.tld"></textarea>
            <p class="text-xs  text-base-content/90">Enter each email on a new line</p>


            <div class="form-control mt-4 hidden">
                <label class="label cursor-pointer">
                  <span class="label-text">Delete when viewed</span>
                  <input name="deletable" type="checkbox" checked="checked" class="checkbox checkbox-primary" />
                </label>
              </div>

              <input type="submit" class="btn btn-secondary mt-4" value="Share the secret"></button>
         </div>

</div>


</body>
</html>
