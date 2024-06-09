<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Open a secret</title>
    @vite('resources/css/app.css')

    <style>
        .bg{
    background-image: url('/bg.jpg');
    @apply bg-cover bg-center;
}

</style>

@vite('resources/js/app.js')
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
    <form class="flex justify-center mt-8" method="POST" action="{{ route('secret.unlock', $receiver->id) }}">
        @csrf
        <div class="card w-96 p-8 border border-base-content/20 bg-base-100/70 backdrop-blur-sm  shadow-xl">
            <h1 class="text-xl font-bold text-center">Open secret</h1>

           <div class="mt-8 flex flex-col">
            <label for="content ">Enter the unlock code sent to : {{ $receiver->email }}</label>
            <div class="flex space-x-3 h-10 mt-4" data-hs-pin-input="">
                <input type="text" id="pin-input-1" required class="pin block w-1/4 text-center border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" data-hs-pin-input-item="">
                <input type="text" id="pin-input-0" required class="pin block w-1/4 text-center border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" data-hs-pin-input-item="" autofocus="">
                <input type="text" id="pin-input-2" required class="pin block w-1/4 text-center border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" data-hs-pin-input-item="">
                <input type="text" id="pin-input-3" required class="pin block w-1/4 text-center border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" data-hs-pin-input-item="">
                <input type="hidden" name="code" id="code">
            </div>
           </div>



              <input type="submit" class="btn btn-secondary mt-4" value="Unlock Now"></button>
         </div>

</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
      var pinInput = document.querySelectorAll('[data-hs-pin-input-item]');

      pinInput.forEach(function(input, index) {
        input.addEventListener('change', function() {
          var code = '';
          for (var i = 0; i < 4; i++) {
            code += index === i ? pinInput[i].value : document.querySelector('#code').value.charAt(i);
          }
          document.querySelector('#code').value = code;
        });
      });
    });
</script>
</body>
</html>
