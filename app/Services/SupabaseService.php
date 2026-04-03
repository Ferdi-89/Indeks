<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SupabaseService
{
    protected string $url;
    protected string $key;

    public function __construct()
    {
        $this->url = rtrim(env('NEXT_PUBLIC_SUPABASE_URL'), '/');
        $this->key = env('NEXT_PUBLIC_SUPABASE_PUBLISHABLE_DEFAULT_KEY');
    }

    protected function headers(): array
    {
        return [
            'apikey' => $this->key,
            'Authorization' => 'Bearer ' . $this->key,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation',
        ];
    }

    protected function endpoint(string $table): string
    {
        return $this->url . '/rest/v1/' . $table;
    }

    /** GET all rows, optional query string filters */
    public function get(string $table, array $params = []): array
    {
        $response = Http::withoutVerifying()->withHeaders($this->headers())
            ->get($this->endpoint($table), $params);
        return is_array($response->json()) ? $response->json() : [];
    }

    /** POST / insert a row */
    public function insert(string $table, array $data): array
    {
        $response = Http::withoutVerifying()->withHeaders($this->headers())
            ->post($this->endpoint($table), $data);
        return is_array($response->json()) ? $response->json() : [];
    }

    /** PATCH / update rows matching filter */
    public function update(string $table, string $column, string $value, array $data): array
    {
        $response = Http::withoutVerifying()->withHeaders(array_merge($this->headers(), ['Prefer' => 'return=representation']))
            ->patch($this->endpoint($table) . '?' . $column . '=eq.' . $value, $data);
        return is_array($response->json()) ? $response->json() : [];
    }

    /** DELETE rows matching filter */
    public function delete(string $table, string $column, string $value): bool
    {
        $response = Http::withoutVerifying()->withHeaders($this->headers())
            ->delete($this->endpoint($table) . '?' . $column . '=eq.' . $value);
        return $response->successful();
    }

    /** Get single row */
    public function find(string $table, string $column, string $value): ?array
    {
        $result = $this->get($table, [$column => 'eq.' . $value, 'limit' => 1]);
        return $result[0] ?? null;
    }
}
