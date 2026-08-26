/**
 * Enterprise Client-Side Scripts
 * Project: Helpdesk ICTBKP
 */

document.addEventListener('DOMContentLoaded', () => {
    // Dynamic Category Switcher in Ticket Creation
    const categoryInputs = document.querySelectorAll('input[name="category"]');
    const sectionEquipment = document.getElementById('section-equipment');
    const sectionMeeting = document.getElementById('section-meeting');
    const sectionMedia = document.getElementById('section-media');

    if (categoryInputs.length > 0) {
        const toggleSections = () => {
            const selected = document.querySelector('input[name="category"]:checked')?.value;
            if (sectionEquipment) {
                sectionEquipment.style.display = (selected === 'PEMINJAMAN_ASET') ? 'block' : 'none';
            }
            if (sectionMeeting) {
                sectionMeeting.style.display = (selected === 'SOKONGAN_MESYUARAT') ? 'block' : 'none';
            }
            if (sectionMedia) {
                sectionMedia.style.display = (selected === 'MEDIA_JURUKAMERA') ? 'block' : 'none';
            }
        };

        categoryInputs.forEach(radio => {
            radio.addEventListener('change', toggleSections);
        });

        // Initialize state
        toggleSections();
    }

    // Modal Helpers
    window.openModal = (modalId) => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    };

    window.closeModal = (modalId) => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    };

    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.flash-alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
});
