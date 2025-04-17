<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>inji-verify-sdk</title>
      <link rel="preconnect" href="https://fonts.bunny.net">
      <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
      <script src="https://unpkg.com/@zxing/library@latest"></script>
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
         white-space: pre-wrap;     
         word-break: break-word;    
         overflow-wrap: break-word;
         }
         #videoPreview {
         width: 300;
         height: 300;
         border: 2px solid #444;
         margin-bottom: 10px;
         }
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
         /* Tab Styles */
         #tabs {
         display: flex;
         justify-content: center;
         margin-bottom: 20px;
         }
         .tab-button {
         padding: 10px 20px;
         border: none;
         background-color: #e0e0e0;
         cursor: pointer;
         border-radius: 4px;
         font-weight: bold;
         margin: 0 5px;
         }
         .tab-button.active {
         background-color: #4caf50;
         color: white;
         }
         img, video {
    max-width: 300px;
    height: auto;
}

      </style>
   </head>
   <body >
      <h1>Upload VC Credential</h1>
      <!-- Tabs -->
      <div id="tabs">
         <button id="tab-upload" class="tab-button active">Upload File</button>
         <button id="tab-scan" class="tab-button">Scan QR</button>
      </div>
      <!-- File Upload Section -->
      <div class="flex items-center justify-center" id="uploadSection">
         <input type="file" id="fileInput" accept="image/*" />
         <span id="statusIcon" style="margin-left: 10px;"></span>
      </div>
      <!-- QR Video Display -->
      <div class="videoDisplay" id="scanSection">
         <video id="videoPreview" autoplay></video>
         
         <div id="resultBox" style="margin-top: 10px;">QR code</div>
         <div id="qrcodeResult" style="margin-top: 10px;"></div>
         <button id="startScan">Start QR Scan</button>
      </div>
      <br>
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
      <script>
         document.addEventListener("DOMContentLoaded", function () {
           const tabUpload = document.getElementById("tab-upload");
           const tabScan = document.getElementById("tab-scan");
           const uploadSection = document.getElementById("uploadSection");
           const scanSection = document.getElementById("scanSection");
         
           tabUpload.addEventListener("click", function () {
             tabUpload.classList.add("active");
             tabScan.classList.remove("active");
             uploadSection.style.display = "flex";
             scanSection.style.display = "none";
           });
         
           tabScan.addEventListener("click", function () {
             tabScan.classList.add("active");
             tabUpload.classList.remove("active");
             uploadSection.style.display = "none";
             scanSection.style.display = "block";
           });
         
           // Optional: Set default visibility
           uploadSection.style.display = "flex";
           scanSection.style.display = "none";
         });
      </script>
   </body>
</html>