<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Renseignement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Dompdf\Options; // ✅ Import correct
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class RenseignementController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all()); 
        // Validation des champs
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'nb_enfants_5_10' => 'nullable|integer|min:0',
            'nb_enfants_11_17' => 'nullable|integer|min:0',
            'numero_whatsapp' => [
                'required',
                'string',
                'max:20',
                'unique:renseignements,numero_whatsapp',
                'regex:/^[0-9]{10}$/',  // Validation regex pour s'assurer que le numéro contient uniquement 10 chiffres
            ],
        ], [
            'numero_whatsapp.unique' => 'Ce numéro WhatsApp est déjà enregistré. Vous avez déjà un compte !',
        ]);

         // 🔥 Afficher les données reçues par Laravel
        // dd($request->all());

        // Vérifier si l'utilisateur existe déjà
        $existant = Renseignement::where('numero_whatsapp', $request->numero_whatsapp)->first();

        if ($existant) {
            return redirect()->back()->with([
                'message' => 'Vous êtes déjà inscrit.',
                'numero_enregistrement' => $existant->numero_enregistrement,
            ]);
        }

        // Générer un numéro d'enregistrement unique
        $numero_enregistrement = mt_rand(10000000, 99999999) . strtoupper(Str::random(2));

         // **Calcul du tarif**
        $tarif = ($request->nb_enfants_5_10 * 10000) + ($request->nb_enfants_11_17 * 10000);
        
        // dd($request->all()); 

        // Enregistrer les données
        $renseignement = Renseignement::create([
            'nom' => $request->nom,
            'prenoms' => $request->prenoms,
            'nb_enfants_5_10' => $request->nb_enfants_5_10,
            'nb_enfants_11_17' => $request->nb_enfants_11_17,
            'numero_whatsapp' => $request->numero_whatsapp,
            'numero_enregistrement' => $numero_enregistrement,
            'tarif' => $tarif,
        ]);
        
        // dd($renseignement->toArray()); 
        

     // Stocker le numéro d'enregistrement et le tarif en session
    Session::put('numero_enregistrement', $numero_enregistrement);
    Session::put('tarif', $tarif);

    // Vérifier que les données sont bien enregistrées en session
    // dd(Session::all());
    
    // Rediriger vers la page de confirmation
    return redirect()->route('confirmation');
        
    }

    public function confirmation()
    {
        // 🔍 Vérifier si la session contient bien les valeurs
        dd([
            'session_numero_enregistrement' => Session::get('numero_enregistrement'),
            'session_tarif' => Session::get('tarif'),
        ]);
    
        // Récupérer le numéro d'enregistrement depuis la session
        $numero_enregistrement = Session::get('numero_enregistrement');
    
        if (!$numero_enregistrement) {
            return redirect()->route('formulaire')->with('error', 'Aucune inscription trouvée.');
        }
    
        // Récupérer l'utilisateur avec ce numéro d'enregistrement
        $renseignement = Renseignement::where('numero_enregistrement', $numero_enregistrement)->first();
    
        if (!$renseignement) {
            return redirect()->route('formulaire')->with('error', 'Aucune inscription trouvée.');
        }
    
        // Récupérer le tarif uniquement depuis la session
        $tarif = Session::get('tarif');
    
        // Vérifier si le tarif est disponible dans la session
        if (is_null($tarif)) {
            return redirect()->route('formulaire')->with('error', 'Tarif non disponible en session.');
        }
    
        
           // Retourner la page de confirmation avec les bonnes données
        return Inertia::render('ConfirmationPage', [
            'message' => 'Inscription réussie !',
            'numero_enregistrement' => $renseignement->numero_enregistrement,
            'tarif' => Session::get('tarif'), // Assurez-vous que cela renvoie bien le tarif
        ]);
    }

   

    public function generateRecu($id)
{
    $renseignement = Renseignement::where('numero_enregistrement', $id)->first();

    if (!$renseignement) {
        return abort(404, 'Reçu non trouvé');
    }

    // ✅ Activer le chargement des images distantes
    $options = new Options();
    $options->set('isRemoteEnabled', true);

    // ✅ Appliquer les options à DomPDF
    $pdf = Pdf::loadView('pdf.recu', ['renseignement' => $renseignement]);
    $pdf->setOptions([
        'isRemoteEnabled' => true,
    ]);

    return $pdf->download('recu_'.$renseignement->numero_enregistrement.'.pdf');
}

public function dashboard()
{
    $renseignements = Renseignement::all();

    return Inertia::render('Dashboard', [
        'renseignements' => $renseignements,
    ]);
}
}
