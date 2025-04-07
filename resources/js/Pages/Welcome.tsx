import { PageProps } from '@/types';
import { Inertia } from '@inertiajs/inertia';
import { Head, useForm, usePage } from '@inertiajs/react';
import '@/Style/Welcome.css';
import image from '@/Assets/blurry-golden-glitter-background-texture.jpg'

export default function Welcome({
    auth,
    laravelVersion,
    phpVersion,
}: PageProps<{ laravelVersion: string; phpVersion: string }>) {
    
    const { message, numero_enregistrement } = usePage().props as { 
        message?: string; 
        numero_enregistrement?: string 
    };

    console.log("Données reçues :", { message, numero_enregistrement });

    const { data, setData, post, processing, errors } = useForm({
        nom: '',
        prenoms: '',
        nb_enfants_5_10: 0,  // ✅ Correction du nom du champ
        nb_enfants_11_17: 0,  // ✅ Correction du nom du champ
        numero_whatsapp: '',
    });
    

    const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        console.log("Données envoyées :", data);  // 👀 Vérification
        post('/renseignements', {
            preserveScroll: true,
            onSuccess: () => {
                Inertia.visit('/confirmation');
            },
        });
    };
    

    return (
        <>
            {/* <Head title="INP-HB" /> */}
            <div className="form-container">
                <div className="form-box">
                     {/* Partie droite : Image */}
                    <div className="form-right">
                        <img src="https://adminsite.inphb.app/imagesdjoro/fablab.jpeg" alt="oups" />
                    </div>
                    {/* Partie gauche : Formulaire */}
                    <div className="form-left">
                        <h1 className="form-title">Formulaire d'Inscription</h1>
                        <form className="form" onSubmit={handleSubmit}>
                            <div className="form-group">
                                <label htmlFor="nom" className="form-label">Nom</label>
                                <input 
                                    type="text" 
                                    id="nom" 
                                    className="form-input" 
                                    value={data.nom} 
                                    onChange={(e) => setData('nom', e.target.value)} 
                                    required 
                                />
                                {errors.nom && <span className="error-text">{errors.nom}</span>}
                            </div>

                            <div className="form-group">
                                <label htmlFor="prenoms" className="form-label">Prénoms</label>
                                <input 
                                    type="text" 
                                    id="prenoms" 
                                    className="form-input" 
                                    value={data.prenoms} 
                                    onChange={(e) => setData('prenoms', e.target.value)} 
                                    required 
                                />
                                {errors.prenoms && <span className="error-text">{errors.prenoms}</span>}
                            </div>

                            <div className="form-group">
                                <label htmlFor="nb_enfants_5_10" className="form-label">Nombre d'enfants (5 - 10 ans)</label>
                                <input 
                                    type="number" 
                                    id="nb_enfants_5_10" 
                                    className="form-input" 
                                    value={data.nb_enfants_5_10}  // ✅ Correction
                                    onChange={(e) => setData('nb_enfants_5_10', Number(e.target.value))}  // ✅ Correction
                                    placeholder="0" 
                                    min="0" 
                                />

                            </div>

                            <div className="form-group">
                                <label htmlFor="nb_enfants_11_17" className="form-label">Nombre d'enfants (11 - 17 ans)</label>
                                <input 
                                    type="number" 
                                    id="nb_enfants_11_17" 
                                    className="form-input" 
                                    value={data.nb_enfants_11_17}  // ✅ Correction
                                    onChange={(e) => setData('nb_enfants_11_17', Number(e.target.value))}  // ✅ Correction
                                    placeholder="0" 
                                    min="0" 
                                />

                            </div>

                            <div className="form-group">
                                <label htmlFor="numero_whatsapp" className="form-label">Numéro WhatsApp</label>
                                <div className="input-group">
                                    <span className="input-prefix">+225</span>
                                    <input
                                        type="text"
                                        id="numero_whatsapp"
                                        className="form-input"
                                        value={data.numero_whatsapp}
                                        onChange={(e) => {
                                            const value = e.target.value.replace(/[^\d]/g, ''); // Garde uniquement les chiffres
                                            if (value.length <= 10) {
                                                setData('numero_whatsapp', value);
                                            }
                                        }}
                                        required
                                        placeholder="Entrez votre numéro"
                                        maxLength={10}
                                    />
                                </div>
                                {errors.numero_whatsapp && <span className="error-text">{errors.numero_whatsapp}</span>}
                            </div>

                            <button type="submit" className="form-submit" disabled={processing}>
                                Enregistrer
                            </button>
                        </form>
                    </div>

                   
                   
                </div>
            </div>
        </>
    );
}