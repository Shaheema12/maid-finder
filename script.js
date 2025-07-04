// City and area data
const areaData = {
    bangalore: ['Indiranagar', 'Koramangala', 'Whitefield', 'HSR Layout', 'Jayanagar'],
    mumbai: ['Andheri', 'Bandra', 'Juhu', 'Powai', 'Worli'],
    delhi: ['Connaught Place', 'Hauz Khas', 'Dwarka', 'Rohini', 'Vasant Kunj'],
    chennai: ['Adyar', 'T. Nagar', 'Anna Nagar', 'Velachery', 'Mylapore']
};

// Update area options based on selected city
document.getElementById('citySelect')?.addEventListener('change', function() {
    const citySelect = this as HTMLSelectElement;
    const areaSelect = document.getElementById('areaSelect') as HTMLSelectElement;
    const selectedCity = citySelect.value;

    // Clear and disable area select if no city is selected
    if (!selectedCity) {
        areaSelect.innerHTML = '<option value="">Select Area</option>';
        areaSelect.disabled = true;
        return;
    }

    // Enable area select and populate options
    areaSelect.disabled = false;
    areaSelect.innerHTML = '<option value="">Select Area</option>';
    
    areaData[selectedCity as keyof typeof areaData].forEach(area => {
        const option = document.createElement('option');
        option.value = area.toLowerCase();
        option.textContent = area;
        areaSelect.appendChild(option);
    });
});

// Form validation
function validateForm(formId: string): boolean {
    const form = document.getElementById(formId) as HTMLFormElement;
    if (!form) return false;

    let isValid = true;
    const inputs = form.querySelectorAll('input[required], select[required]');
    
    inputs.forEach(input => {
        if (!(input as HTMLInputElement).value.trim()) {
            isValid = false;
            input.classList.add('error');
        } else {
            input.classList.remove('error');
        }
    });

    return isValid;
}

// Mobile menu toggle
const menuButton = document.querySelector('.menu-button');
const navLinks = document.querySelector('.nav-links');

menuButton?.addEventListener('click', () => {
    navLinks?.classList.toggle('active');
});

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const href = this.getAttribute('href');
        if (href) {
            document.querySelector(href)?.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});