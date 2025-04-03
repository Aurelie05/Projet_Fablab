import { usePage } from '@inertiajs/react';
import '@/Style/Conf.css';

const ConfirmationPage = () => {
    const { message, numero_enregistrement, tarif } = usePage().props as { 
        message?: string; 
        numero_enregistrement?: string;
        tarif?: number;
    };

    const handleDownloadReceipt = () => {
        // Création du contenu du reçu
        const receiptContent = `Reçu d'inscription\n\nNom : Inconnu\nNuméro d'enregistrement : ${numero_enregistrement}\nTarif : ${tarif} FCFA\n\nMerci pour votre inscription !`;
        
        // Création du Blob et téléchargement
        const blob = new Blob([receiptContent], { type: 'text/plain' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = `Recu_${numero_enregistrement}.txt`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    };
    console.log('Tarif:', tarif);
    
    return (
        <div className="confirmation-container">
            <div className="confirmation-box">
                <h1 className="confirmation-title">{message || "Inscription réussie !"}</h1>
                <p className="confirmation-number">
                    Votre numéro d'enregistrement est : <strong>{numero_enregistrement || "inconnu"}</strong>
                </p>
                <p className="confirmation-tarif">
                    Montant a payé : <strong>{tarif !== null && tarif !== undefined ? `${tarif} FCFA` : "Non disponible"}</strong>
                </p>
                <button 
                    className="download-btn" 
                    onClick={() => window.open(`/recu/${numero_enregistrement}`, '_blank')}
                >
                    Télécharger la facture en PDF
                </button>
            </div>
        </div>
    );
};

export default ConfirmationPage;
