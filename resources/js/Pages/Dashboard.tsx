import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, usePage, router } from '@inertiajs/react';
import { PageProps } from '@/types';

type RenseignementType = {
    id: number;
    nom: string;
    prenoms: string;
    nb_enfants_5_10: number;
    nb_enfants_11_17: number;
    numero_whatsapp: string;
    numero_enregistrement: string;
    tarif: string;
};
type Props = {
    auth: PageProps['auth']; // Add auth property
    renseignements: RenseignementType[];
};


export default function Dashboard({ auth }: PageProps<{ renseignements: RenseignementType[] }>) {
    const { renseignements } = usePage<Props>().props;
    const handleDelete = (id: number) => {
        if (confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) {
            router.delete(`/renseignement/${id}`);
        }
    };

    return (
        <AuthenticatedLayout>
            <Head title="Dashboard" />

            <div className="p-4 sm:p-6">
                <h1 className="text-xl sm:text-2xl font-bold mb-4">Liste des inscrits</h1>
                <div className="w-full overflow-x-auto">
                    <table className="min-w-full table-auto border border-gray-200 text-sm sm:text-base">
                        <thead>
                            <tr className="bg-gray-100">
                                <th className="border px-2 py-2 sm:px-4 sm:py-2">Nom</th>
                                <th className="border px-2 py-2 sm:px-4 sm:py-2">Prénoms</th>
                                <th className="border px-2 py-2 sm:px-4 sm:py-2 hidden md:table-cell">Enfants (5-10)</th>
                                <th className="border px-2 py-2 sm:px-4 sm:py-2 hidden md:table-cell">Enfants (11-17)</th>
                                <th className="border px-2 py-2 sm:px-4 sm:py-2 hidden sm:table-cell">WhatsApp</th>
                                <th className="border px-2 py-2 sm:px-4 sm:py-2 hidden lg:table-cell">N° Enregistrement</th>
                                <th className="border px-2 py-2 sm:px-4 sm:py-2">Tarif</th>
                                <th className="border px-2 py-2 sm:px-4 sm:py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {renseignements.map((item) => (
                                <tr key={item.id}>
                                    <td className="border px-2 py-2 sm:px-4 sm:py-2">{item.nom}</td>
                                    <td className="border px-2 py-2 sm:px-4 sm:py-2">{item.prenoms}</td>
                                    <td className="border px-2 py-2 sm:px-4 sm:py-2 hidden md:table-cell">{item.nb_enfants_5_10}</td>
                                    <td className="border px-2 py-2 sm:px-4 sm:py-2 hidden md:table-cell">{item.nb_enfants_11_17}</td>
                                    <td className="border px-2 py-2 sm:px-4 sm:py-2 hidden sm:table-cell">{item.numero_whatsapp}</td>
                                    <td className="border px-2 py-2 sm:px-4 sm:py-2 hidden lg:table-cell">{item.numero_enregistrement}</td>
                                    <td className="border px-2 py-2 sm:px-4 sm:py-2">{item.tarif}</td>
                                    <td className="border px-2 py-2 sm:px-4 sm:py-2 text-center">
                                        <button
                                            onClick={() => handleDelete(item.id)}
                                            className="bg-red-500 hover:bg-red-600 text-white px-2 sm:px-3 py-1 rounded text-xs sm:text-sm"
                                        >
                                            Supprimer
                                        </button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>

        </AuthenticatedLayout>
    );
}
