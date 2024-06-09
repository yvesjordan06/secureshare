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
    <div class="flex justify-center mt-8" >

        <div class="card w-96 p-8 border border-base-content/20 bg-base-100/70 backdrop-blur-sm  shadow-xl">
            <h1 class="text-xl font-bold text-center">Your secret</h1>

           <div class="mt-8 flex flex-col">
            <div class=" mt-4 flex space-x-3 whitespace-pre p-4 rounded-md border border-primary font-bold">
               <p>{{ $secret->content }}</p>
            </div>

            <p class="mt-2 text-sm">This secret will be deleted when you view it</p>
           </div>



              <button  class="btn btn-secondary mt-4" id="copy"  data-clipboard-text="{{ $secret->content }}" >Copy</button>
         </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.11/dist/clipboard.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {

      var clipboard = new ClipboardJS("#copy");

      clipboard.on('success', function(e) {
       document.querySelector('#copy').innerHTML = 'Copied';
      });







    });
</script>
</body>
</html>
