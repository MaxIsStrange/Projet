const erreur= 'Erreur de connexion l\'identifiant ou le mot de passe est incorrect';

bulmaToast.toast({
    type: 'is-danger',
    message: erreur,
    position: 'bottom-center',
    duration: 10000,
    dismissible: true,
    pauseOnHover: true,
})