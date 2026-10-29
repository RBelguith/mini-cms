<x-layout>
    <x-slot:title>Accueil - Mini-CMS</x-slot:title>

    <section class="py-10">
        <h1 class="text-4xl font-bold mb-4">Bienvenue sur Mini-CMS</h1>
        <p class="text-lg text-gray-600 mb-6 max-w-2xl">
            Une petite plateforme de publication construite pas à pas pendant l'Atelier Framework Côté Serveur.
        </p>
        <a href="{{ route('posts.index') }}" class="inline-block rounded-md bg-indigo-600 px-5 py-2.5 font-medium text-white hover:bg-indigo-700">
            Lire les articles
        </a>
    </section>

    <h2 class="text-2xl font-bold mb-4">Parcourir par catégorie</h2>
    <ul class="mb-10 flex flex-wrap gap-3" aria-label="Catégories">
        @foreach ($categories as $category)
            <li>
                <a href="{{ route('posts.category', $category) }}" class="inline-block rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-700 hover:border-indigo-600 hover:text-indigo-600">{{ $category->name }} ({{ $category->posts_count }})</a>
            </li>
        @endforeach
    </ul>

    @if ($popularTags->isNotEmpty())
        <h2 class="text-2xl font-bold mb-4">Tags populaires</h2>
        <ul class="mb-10 flex flex-wrap gap-3" aria-label="Tags populaires">
            @foreach ($popularTags as $tag)
                <li>
                    <a href="{{ route('posts.tag', $tag) }}" class="inline-block rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-700 hover:border-indigo-600 hover:text-indigo-600">{{ $tag->name }} ({{ $tag->posts_count }})</a>
                </li>
            @endforeach
        </ul>
    @endif

    <section>
        <x-page-header title="Derniers articles publiés" />

        <div class="grid gap-6 md:grid-cols-3">
            @forelse ($latestPosts as $post)
                <x-post-card :post="$post" />
            @empty
                <x-alert type="info" title="Aucun article" class="md:col-span-3">
                    Aucun article n'a encore été publié.
                </x-alert>
            @endforelse
        </div>
    </section>
</x-layout>
