function initializeZkLogin() {
    // Load Google OAuth
    google.accounts.id.initialize({
        client_id: 'NO-GOOGLE-CLIENTID-FOR-YOU.apps.googleusercontent.com',
        callback: handleCredentialResponse
    });

    google.accounts.id.renderButton(
        document.getElementById('zkLoginContainer'),
        { theme: 'outline', size: 'large' }
    );
}

function handleCredentialResponse(response) {
    // Send JWT to backend for zk proof generation
    fetch('/api/zklogin', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ credential: response.credential })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            window.location.href = '/shadownotes/public/home';
        }
    });
}
