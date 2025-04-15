import './bootstrap';
import './validator-test';
import { VCverification, VCverificationScanQrcode } from 'inji-verify-sdk';


fileInput.addEventListener('change', async (event) => {

  const file = event.target.files[0];
  if (!file) return;
  let myresult = await VCverification(file, 'https://injiverify.dpgongcp.com/v1/verify/vc-verification')
  console.log(myresult);

  console.log("❌ Not a GraduationCredential");
  statusIcon.textContent = "❌";
  statusIcon.style.color = "red";
  // Check verification status first
  if (myresult.result.verificationStatus !== "SUCCESS" || myresult.result.verificationStatus === 'INVALID') {
    console.log("❌ Not a GraduationCredential");
    statusIcon.textContent = "❌";
    statusIcon.style.color = "red";

  } else {
    try {
      // Parse the stringified JSON
      const parsedData = JSON.parse(myresult.credential);
      console.log(parsedData);

      const credentialSubject = parsedData.credentialSubject;
      console.log(credentialSubject);

      if (credentialSubject.type === "GraduationCredential") {
        console.log("✔️ Credential is GraduationCredential");
        statusIcon.textContent = "✅";
        statusIcon.style.color = "green";
        // Update form fields
        document.getElementById('studentId').value = credentialSubject.studentId || '';
        document.getElementById('major').value = credentialSubject.major || '';
        document.getElementById('graduationDate').value = credentialSubject.graduationDate || '';
        document.getElementById('studentName').value = credentialSubject.studentName || '';
        document.getElementById('degree').value = credentialSubject.degree || '';
        document.getElementById('UIN').value = credentialSubject.UIN || '';
        document.getElementById('type').value = credentialSubject.type || '';
      } else {
        console.log("❌ Not a GraduationCredential");
        statusIcon.textContent = "❌";
        statusIcon.style.color = "red";
      }
    } catch (e) {
      console.error("Error parsing myresult.myresult:", e);
      statusIcon.textContent = "❌";
      statusIcon.style.color = "red";
    }
  }

})

// document.addEventListener('DOMContentLoaded', async () => {
//   const video = document.getElementById('videoPreview');
//   const resultBox = document.getElementById('resultBox');
//   const startBtn = document.getElementById('startScan');

//   if (!video || !resultBox || !startBtn) {
//     console.error("One or more required elements are missing from the DOM.");
//     return;
//   }

//   // Import the BrowserQRCodeReader module asynchronously
//   import('@zxing/browser').then(({ BrowserQRCodeReader }) => {
//     const codeReader = new BrowserQRCodeReader();
//     let activeStream = null;
//     let scannedText = ""; // <-- define outside to access after scanning

//     startBtn.addEventListener('click', async () => {
//       resultBox.textContent = "Scanning...";
//       scannedText = ""; // reset before each scan

//       try {
//         // Start the scanning process
//         const result = await codeReader.decodeOnceFromVideoDevice(undefined, video);
//         scannedText = result.text;

//         resultBox.textContent = "QR Code: " + scannedText;

//         // Stop the video stream if it's active
//         if (video.srcObject) {
//           const stream = video.srcObject;
//           stream.getTracks().forEach(track => track.stop()); // Stop the tracks of the stream
//           video.srcObject = null; // Clear the srcObject to free resources
//         }

//       } catch (err) {
//         resultBox.textContent = "Error: " + err.message; // Make sure to use err.message for the error string
//         console.error("QR Scan Error:", err); // Log error for debugging
//       }

//       // ✅ Now you can safely use scannedText here (outside try-catch)
//       if (scannedText) {
//         console.log("Scanned QR outside try:", scannedText);



//         // Use the scannedText in further validation
//         let output = scannedText;
//         console.log(typeof output);
//         try {
//           let myresult = await VCverificationScanQrcode(scannedText, 'https://injiverify.dpgongcp.com/v1/verify/vc-verification');
//           console.log(myresult);
//           document.getElementById("scanjsonOutput").textContent = JSON.stringify(myresult, null, 2);
//         } catch (err) {
//           console.error("Validation Error:", err);
//         }
//       }
//     });
//   }).catch(err => {
//     console.error("Failed to import @zxing/browser:", err);
//   });
// });


