document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu');
    const navMenu = document.querySelector('nav ul');
    
    if (mobileMenuBtn && navMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            navMenu.classList.toggle('show');
        });
    }
    
    // Header scroll effect
    window.addEventListener('scroll', function() {
        const header = document.querySelector('header');
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

// Contact form submission (with alert + still send to FormSubmit)
const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;

        const subjectSelect = document.getElementById('subject');
        const subject = subjectSelect.options[subjectSelect.selectedIndex].text;

        alert(`Thank you, ${name}! Your message has been received. We'll contact you at ${email} regarding "${subject}".`);

        // Wait a moment, then submit the form to FormSubmit
        setTimeout(() => {
            contactForm.submit();
        }, 300);
    });
  }
});

// gallery setup
document.addEventListener("DOMContentLoaded", () => {
  // Upload buttons
  document.getElementById("imageUploadBtn")?.addEventListener("click", () => upload("image", "imageUpload"));
  document.getElementById("videoUploadBtn")?.addEventListener("click", () => upload("video", "videoUpload"));
  document.getElementById("musicUploadBtn")?.addEventListener("click", () => upload("audio", "musicUpload"));

  // Refresh buttons
  document.querySelectorAll(".refresh").forEach(btn => {
    btn.addEventListener("click", () => loadGallery(btn.dataset.type));
  });

  // Load galleries on startup
  ["image", "video", "audio"].forEach(loadGallery);
});

async function upload(type, inputId) {
  const input = document.getElementById(inputId);
  const file = input?.files?.[0];
  if (!file) return alert("Select a file first.");

  const fd = new FormData();
  fd.append("file", file);
  fd.append("type", type);

  try {
    const res = await fetch(`${API_BASE}/upload`, { method: "POST", body: fd });
    if (!res.ok) throw new Error(await res.text());
    await loadGallery(type);26
    input.value = ""; 
  } catch (e) {
    console.error(e);
    alert("Upload failed.");
  }
}

async function loadGallery(type) {
  const containerId = type === "image" ? "imageGallery" : type === "video" ? "videoGallery" : "musicGallery";
  const container = document.getElementById(containerId);
  if (!container) return;
  container.innerHTML = "Loading...";

  try {
    const res = await fetch(`${API_BASE}/list?type=${encodeURIComponent(type)}`);
    const data = await res.json();

    container.innerHTML = "";
    data.forEach(item => {
      const card = document.createElement("div");
      card.className = "card";

      const media = document.createElement("div");
      media.className = "media";

      if (type === "image") {
        media.innerHTML = `<img src="${API_BASE}/file?key=${encodeURIComponent(item.key)}&inline=1" alt="${item.name}">`;
      } else if (type === "video") {
        media.innerHTML = `<video controls src="${API_BASE}/file?key=${encodeURIComponent(item.key)}&inline=1"></video>`;
      } else {
        media.innerHTML = `<audio controls src="${API_BASE}/file?key=${encodeURIComponent(item.key)}&inline=1"></audio>`;
      }

      const meta = `<div class="meta">${item.name} • ${(item.size/1024).toFixed(1)} KB</div>`;
      const actions = `
        <div class="actions">
          <a href="${API_BASE}/file?key=${encodeURIComponent(item.key)}&download=1" download="${item.name}" class="btn">Download</a>
          <button onclick="deleteFile('${item.key}', '${type}')">Delete</button>
        </div>
      `;

      card.innerHTML = media.outerHTML + meta + actions;
      container.appendChild(card);
    });

    if (data.length === 0) container.innerHTML = "<em>No files yet. Upload something!</em>";
  } catch (e) {
    console.error(e);
    container.innerHTML = "<em>Failed to load files.</em>";
  }
}

async function deleteFile(key, type) {
  if (!confirm("Delete this file?")) return;
  const res = await fetch(`${API_BASE}/delete?key=${encodeURIComponent(key)}`, { method: "DELETE" });
  if (!res.ok) return alert("Delete failed.");
  await loadGallery(type);
}

function confirmDelete() {
  return confirm("Are you sure you want to delete this file?");
}

function confirmDelete() {
    return confirm("Are you sure you want to delete this file?");
}



