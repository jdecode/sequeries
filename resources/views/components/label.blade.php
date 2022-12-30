@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-lg text-gray-500']) }}>
    {{ $value ?? $slot }}
</label>
