<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>inji-verify-sdk</title>
      <!-- Fonts -->
      <link rel="preconnect" href="https://fonts.bunny.net">
      <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
      <!-- In welcome.blade.php -->
      <script src="https://unpkg.com/@zxing/library@latest"></script>
      <!-- Include Vite-built assets -->
      @vite(['resources/css/app.css', 'resources/js/app.js'])
      <style>
         body {
         font-family: Arial, sans-serif;
         background-color: #f9f9f9;
         margin: 0;
         padding: 20px;
         }
         #app {
         max-width: 600px;
         margin: 0 auto;
         padding: 20px;
         background-color: #fff;
         border-radius: 8px;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
         }
         h1 {
         font-size: 24px;
         text-align: center;
         color: #333;
         }
         #fileInput {
         display: block;
         margin: 20px auto;
         padding: 10px;
         font-size: 16px;
         color: #555;
         border: 2px solid #ddd;
         border-radius: 4px;
         background-color: #f1f1f1;
         width: 100%;
         cursor: pointer;
         }
         #fileInput:hover {
         border-color: #4CAF50;
         }
         #result {
         margin-top: 20px;
         padding: 10px;
         font-size: 16px;
         text-align: center;
         color: #333;
         background-color: #e7f7e7;
         border: 1px solid #4CAF50;
         border-radius: 4px;
         }
         /* Style for loading or error messages */
         #result.loading {
         background-color: #fff3cd;
         color: #856404;
         border-color: #ffeeba;
         }
         #result.error {
         background-color: #f8d7da;
         color: #721c24;
         border-color: #f5c6cb;
         }
         pre {
         width: 100%;
         max-width: 100%;
         background: #f4f4f4;
         padding: 10px;
         border-radius: 6px;
         font-family: monospace;
         white-space: pre-wrap;      /* Allows wrapping of long lines */
         word-break: break-word;     /* Breaks long words */
         overflow-wrap: break-word;
         }
         #videoPreview {
         width: 400px;
         height: auto;
         border: 2px solid #444;
         margin-bottom: 10px;
         }
         /* Style for form inputs and labels */
         form {
         width: 100%;
         margin: 0 auto;
         }
         .form-group {
         margin-bottom: 20px;
         }
         label {
         display: block;
         width: 100%;
         margin-bottom: 5px;
         font-weight: bold;
         color: #444;
         }
         input[type="text"],
         input[type="date"] {
         width: 100%;
         padding: 10px;
         box-sizing: border-box;
         border: 1px solid #ccc;
         border-radius: 4px;
         }
         button {
         width: 100%;
         padding: 10px;
         background-color: #4CAF50;
         color: white;
         border: none;
         border-radius: 4px;
         font-weight: bold;
         cursor: pointer;
         }
         button:hover {
         background-color: #45a049;
         }
      </style>
   </head>
   <body >
      <h1>Upload VC Credential</h1>
      <div class="flex items-center justify-center">
         <input type="file" id="fileInput" accept="image/*" />
         <span id="statusIcon" style="margin-left: 10px;"></span>
      </div>
      <!-- <pre id="jsonOutput">Loading...</pre> -->
      <form id="credentialForm">
         <div>
            <label for="studentId">Student ID:</label>
            <input type="text" id="studentId" name="studentId" value="">
         </div>
         <div>
            <label for="major">Major:</label>
            <input type="text" id="major" name="major" value="">
         </div>
         <div>
            <label for="graduationDate">Graduation Date:</label>
            <input type="date" id="graduationDate" name="graduationDate" value="">
         </div>
         <div>
            <label for="studentName">Student Name:</label>
            <input type="text" id="studentName" name="studentName" value="">
         </div>
         <div>
            <label for="degree">Degree:</label>
            <input type="text" id="degree" name="degree" value="">
         </div>
         <div>
            <label for="UIN">UIN:</label>
            <input type="text" id="UIN" name="UIN" value="">
         </div>
         <div>
            <label for="type">Credential Type:</label>
            <input type="text" id="type" name="type" value="">
         </div>
      </form>
      <!-- <video id="videoPreview" width="400" height="auto" style="border: 2px solid #444;"></video>
         <button id="startScan">Start Scan</button>
         <pre id="resultBox">QR result will appear here...</pre>
         <pre id="scanjsonOutput">Loading...</pre> -->
      <!-- @if (Route::has('login'))
         <div class="h-14.5 hidden lg:block"></div>
         @endif -->
   </body>
</html>