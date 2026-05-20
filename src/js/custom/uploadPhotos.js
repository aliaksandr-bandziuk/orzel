export function initUploadPhotos() {
  const fileInputs = document.querySelectorAll('input[type="file"][name="wheel_photos[]"]');

  if (!fileInputs.length) return;

  fileInputs.forEach((fileInput) => {
    const fileList = fileInput.closest("form")?.querySelector(".file-list");

    if (!fileList) return;

    fileInput.addEventListener("change", () => {
      fileList.innerHTML = "";

      if (!fileInput.files.length) return;

      Array.from(fileInput.files).forEach((file) => {
        const item = document.createElement("div");
        item.className = "file-item";

        const fileSizeKb = Math.round(file.size / 1024);
        item.textContent = `${file.name} (${fileSizeKb} KB)`;

        fileList.appendChild(item);
      });
    });
  });
}