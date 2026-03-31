<!-- Global Modal Alert System -->
<div id="globalModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10001; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background: white; border-radius: 16px; width: 90%; max-width: 450px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); animation: slideUp 0.3s ease; overflow: hidden;">
        <!-- Modal Header -->
        <div id="modalHeader" style="padding: 24px; border-bottom: 2px solid #e5e7eb; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 id="modalTitle" style="margin: 0; font-size: 1.3rem; font-weight: 700; color: #1a1a1a;"></h3>
                <button onclick="closeModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #9ca3af; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='#f0f0f0'; this.style.color='#1a1a1a';" onmouseout="this.style.background='none'; this.style.color='#9ca3af';">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <div style="padding: 24px;">
            <p id="modalMessage" style="margin: 0; color: #666; font-size: 1rem; line-height: 1.6;"></p>
        </div>

        <!-- Modal Footer -->
        <div style="padding: 16px 24px; border-top: 1px solid #e5e7eb; background: #f9fafb; display: flex; gap: 10px; justify-content: flex-end;">
            <button id="modalSecondaryBtn" onclick="closeModal()" style="background: #e5e7eb; color: #1a1a1a; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: none;" onmouseover="this.style.background='#d1d5db';" onmouseout="this.style.background='#e5e7eb';">
                Cancel
            </button>
            <button id="modalPrimaryBtn" onclick="closeModal()" style="background: linear-gradient(135deg, #c8102e 0%, #ff1744 100%); color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(200,16,46,0.2);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(200,16,46,0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(200,16,46,0.2)';">
                OK
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
// Global Modal Alert Function - Replaces window.alert()
function showAlert(title, message, callback = null) {
    const modal = document.getElementById('globalModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    const primaryBtn = document.getElementById('modalPrimaryBtn');
    const secondaryBtn = document.getElementById('modalSecondaryBtn');

    // Determine icon and header gradient based on title
    let headerStyle = 'linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%)';
    let buttonStyle = 'linear-gradient(135deg, #c8102e 0%, #ff1744 100%)';
    let icon = '';

    if (title.toLowerCase().includes('success') || title.toLowerCase().includes('successfully')) {
        headerStyle = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
        buttonStyle = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
        icon = '<i class="fas fa-check-circle" style="color: white; margin-right: 10px;"></i>';
    } else if (title.toLowerCase().includes('error') || title.toLowerCase().includes('failed')) {
        headerStyle = 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)';
        buttonStyle = 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)';
        icon = '<i class="fas fa-exclamation-circle" style="color: white; margin-right: 10px;"></i>';
    } else if (title.toLowerCase().includes('warning')) {
        headerStyle = 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)';
        buttonStyle = 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)';
        icon = '<i class="fas fa-exclamation-triangle" style="color: white; margin-right: 10px;"></i>';
    } else if (title.toLowerCase().includes('info')) {
        headerStyle = 'linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%)';
        buttonStyle = 'linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%)';
        icon = '<i class="fas fa-info-circle" style="color: white; margin-right: 10px;"></i>';
    }

    // Update modal content
    document.getElementById('modalHeader').style.background = headerStyle;
    modalTitle.innerHTML = icon + (title || 'Alert');
    if (title.toLowerCase().includes('success') || title.toLowerCase().includes('error') || title.toLowerCase().includes('warning')) {
        modalTitle.style.color = 'white';
    } else {
        modalTitle.style.color = '#1a1a1a';
    }
    modalMessage.textContent = message;
    primaryBtn.style.background = buttonStyle;
    secondaryBtn.style.display = 'none';

    // Set callback for primary button if provided
    if (callback) {
        primaryBtn.onclick = function() {
            closeModal();
            if (typeof callback === 'function') callback();
        };
    } else {
        primaryBtn.onclick = closeModal;
    }

    // Show modal
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    const modal = document.getElementById('globalModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    const modal = document.getElementById('globalModal');
    if (event.target === modal) {
        closeModal();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});

// Sidebar and Menu Toggle Script - For all dashboard pages
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const backdrop = document.getElementById('sidebarBackdrop');
    const sidebar = document.querySelector('.sidebar');

    if (menuToggle && menuToggle.dataset.sidebarManaged === 'true') {
        return;
    }

    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            if (backdrop) backdrop.classList.toggle('active');
        });
    }

    if (backdrop && sidebar) {
        backdrop.addEventListener('click', function() {
            sidebar.classList.remove('active');
            backdrop.classList.remove('active');
        });
    }

    // Close sidebar when a link is clicked (mobile)
    if (sidebar) {
        sidebar.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) {
                    sidebar.classList.remove('active');
                    if (backdrop) backdrop.classList.remove('active');
                }
            });
        });
    }
});

// Notification Modal Functions
function showNotifications() {
    const modal = document.getElementById('notificationModal');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function closeNotifications() {
    const modal = document.getElementById('notificationModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Close notification modal when clicking outside
window.addEventListener('click', function(event) {
    const modal = document.getElementById('notificationModal');
    if (modal && event.target === modal) {
        closeNotifications();
    }
});
</script>
