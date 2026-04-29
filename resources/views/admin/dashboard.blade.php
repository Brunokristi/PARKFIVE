@extends('layouts.admin')

@section('content')
    <div class="grid gap-8">
        <section class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-semibold">Manage hotel</h1>
                    <p class="mt-2 text-sm text-neutral-400">Edit hotel basics, page content, and the structured property data that powers the frontend.</p>
                </div>
                <div class="rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-neutral-300">
                    <div class="font-medium text-white">{{ $hotel->name }}</div>
                    <div>{{ $hotel->slug }}</div>
                </div>
            </div>
        </section>

        <section class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <h2 class="text-xl font-semibold">Hotel settings</h2>
            <form class="mt-4 grid gap-4" method="post" action="/admin/settings">
                @csrf
                <div class="grid gap-4 md:grid-cols-3">
                    <label class="grid gap-2">
                        <span class="text-sm text-neutral-400">Name</span>
                        <input name="name" value="{{ old('name', $settings['name']) }}" class="rounded-lg border border-white/10 bg-neutral-950 px-4 py-3 text-white" />
                    </label>
                    <label class="grid gap-2">
                        <span class="text-sm text-neutral-400">Slug</span>
                        <input name="slug" value="{{ old('slug', $settings['slug']) }}" class="rounded-lg border border-white/10 bg-neutral-950 px-4 py-3 text-white" />
                    </label>
                    <label class="grid gap-2">
                        <span class="text-sm text-neutral-400">Status</span>
                        <input name="status" value="{{ old('status', $settings['status']) }}" class="rounded-lg border border-white/10 bg-neutral-950 px-4 py-3 text-white" />
                    </label>
                </div>

                <label class="grid gap-2">
                    <span class="text-sm text-neutral-400">Domains, one per line</span>
                    <textarea name="domains" rows="3" class="rounded-lg border border-white/10 bg-neutral-950 px-4 py-3 text-white">{{ old('domains', implode("\n", $settings['domains'])) }}</textarea>
                </label>

                <div>
                    <button class="rounded-full bg-white px-5 py-2 text-sm font-semibold text-neutral-950" type="submit">Save settings</button>
                </div>
            </form>
        </section>

        <section class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <h2 class="text-xl font-semibold">Page content JSON</h2>
            <form class="mt-4 grid gap-4" method="post" action="/admin/pages">
                @csrf
                <label class="grid gap-2">
                    <span class="text-sm text-neutral-400">Current page payload</span>
                    <textarea name="pages_json" rows="20" class="rounded-lg border border-white/10 bg-neutral-950 px-4 py-3 font-mono text-sm text-white">{{ old('pages_json', $pageContentsJson) }}</textarea>
                </label>
                <div>
                    <button class="rounded-full bg-white px-5 py-2 text-sm font-semibold text-neutral-950" type="submit">Save page content</button>
                </div>
            </form>
        </section>

        <section class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <h2 class="text-xl font-semibold">Property content JSON</h2>
            <p class="mt-2 text-sm text-neutral-400">This updates room types, features, images, sections, and translations together.</p>
            <form class="mt-4 grid gap-4" method="post" action="/admin/property">
                @csrf
                <label class="grid gap-2">
                    <span class="text-sm text-neutral-400">Property payload</span>
                    <textarea name="property_json" rows="28" class="rounded-lg border border-white/10 bg-neutral-950 px-4 py-3 font-mono text-sm text-white">{{ old('property_json', $propertyJson) }}</textarea>
                </label>
                <div>
                    <button class="rounded-full bg-white px-5 py-2 text-sm font-semibold text-neutral-950" type="submit">Save property content</button>
                </div>
            </form>
        </section>
    </div>
@endsection