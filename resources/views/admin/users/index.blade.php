<x-layout>
    <x-slot:title>Utilisateurs - Mini-CMS</x-slot:title>

    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <h1 class="text-3xl font-bold text-gray-900">Utilisateurs</h1>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-gray-200 text-gray-600">
                <tr>
                    <th scope="col" class="py-2 pr-4 font-medium">Nom</th>
                    <th scope="col" class="py-2 pr-4 font-medium">E-mail</th>
                    <th scope="col" class="py-2 pr-4 font-medium">Rôle</th>
                    <th scope="col" class="py-2 pr-4 font-medium">Articles</th>
                    <th scope="col" class="py-2 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b border-gray-100 align-top">
                        <td class="py-3 pr-4 font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="py-3 pr-4 text-gray-600">{{ $user->email }}</td>
                        <td class="py-3 pr-4">
                            <span @class([
                                'rounded px-2 py-1 text-xs font-medium',
                                'bg-indigo-100 text-indigo-700' => $user->isAdmin(),
                                'bg-gray-100 text-gray-700' => ! $user->isAdmin(),
                            ])>
                                {{ $user->isAdmin() ? 'Administrateur' : 'Auteur' }}
                            </span>
                        </td>
                        <td class="py-3 pr-4 text-gray-600">{{ $user->posts()->count() }}</td>
                        <td class="py-3">
                            @if ($user->is(auth()->user()))
                                <span class="text-sm text-gray-500">Votre compte</span>
                            @else
                                <details>
                                    <summary class="cursor-pointer rounded-md border border-indigo-600 px-4 py-2 text-sm font-medium text-indigo-600 hover:bg-indigo-50">
                                        Passer en {{ $user->isAdmin() ? 'auteur' : 'administrateur' }}
                                    </summary>

                                    <form method="POST" action="{{ route('admin.users.role', $user) }}" class="mt-3 rounded-md border border-indigo-200 bg-indigo-50 p-4">
                                        @csrf
                                        @method('PATCH')

                                        <input type="hidden" name="role" value="{{ $user->isAdmin() ? 'author' : 'admin' }}">

                                        <p class="mb-3 text-sm text-indigo-900">
                                            {{ $user->isAdmin()
                                                ? 'Retirer le rôle administrateur à '.$user->name.' ? Il ne pourra plus gérer les catégories, les tags et les utilisateurs.'
                                                : 'Donner le rôle administrateur à '.$user->name.' ? Il pourra gérer les catégories, les tags et les utilisateurs.' }}
                                        </p>
                                        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Confirmer le changement de rôle</button>
                                    </form>
                                </details>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-500">Aucun utilisateur pour l'instant.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
