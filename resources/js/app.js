import './bootstrap';

import { vcVerification } from 'inji-verify-sdk';

function resultView(response) {
  console.log("❌ Not a GraduationCredential");
  statusIcon.textContent = "❌";

  // Check verification status first
  if (response.data.result !== "SUCCESS" || response.data.result === 'INVALID') {
    console.log("❌ Not a GraduationCredential");
    statusIcon.textContent = "❌";
    statusIcon.style.color = "red";

  } else {
    try {
      // Parse the stringified JSON
      const parsedData = JSON.parse(response.data.credential)
      debugger
      console.log(parsedData);

      const credentialSubject = parsedData.credentialSubject;
      console.log(credentialSubject);
      const hasCourses = Array.isArray(credentialSubject.courses) && credentialSubject.courses.length > 0;

      console.log(hasCourses)
      if (hasCourses) {
        console.log("✔️ Credential is GraduationCredential");
        statusIcon.textContent = "✅";
        statusIcon.style.color = "green";
      } else {
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
      }

    } catch (e) {
      console.error("Error parsing myresult.myresult:", e);
      statusIcon.textContent = "❌";
      statusIcon.style.color = "red";
    }
  }
}
fileInput.addEventListener('change', async (event) => {

  const file = event.target.files[0];
  if (!file) return;
  let response = await vcVerification(file, 'https://injiverify.dpgongcp.com/v1/verify/vc-verification');
  console.log("Raw response:", response);
  resultView(response);
  console.log(response.data.result)




})

import { BrowserQRCodeReader } from '@zxing/browser';

document.addEventListener('DOMContentLoaded', async () => {
  const video = document.getElementById('videoPreview');

  const startBtn = document.getElementById('startScan');

  if (!video || !startBtn) {
    console.error("One or more required elements are missing from the DOM.");
    return;
  }

  const codeReader = new BrowserQRCodeReader();
  let scannedText = "";

  startBtn.addEventListener('click', async () => {
    resultBox.textContent = "Scanning...";
    scannedText = "";

    try {
      const result = await codeReader.decodeOnceFromVideoDevice(undefined, video);
      scannedText = result.text;
      // resultBox.textContent = "QR Code: " + scannedText;

      // Stop the video stream
      if (video.srcObject) {
        const stream = video.srcObject;
        stream.getTracks().forEach(track => track.stop());
        video.srcObject = null;
      }

    } catch (err) {
      resultBox.textContent = "Error: " + err.message;
      console.error("QR Scan Error:", err);
    }

    if (scannedText) {
      console.log("Scanned QR outside try:", scannedText);

      try {
        let response = await vcVerification(scannedText, 'https://injiverify.dpgongcp.com/v1/verify/vc-verification');
        console.log("Raw response:", response);
        resultView(response);
      } catch (err) {
        console.error("Validation Error:", err);
      }
    }
  });
});

