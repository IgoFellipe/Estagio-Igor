@props(['users', 'startPosition' => 4])

<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead class="bg-slate-50 border-b border-gray-100">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-unifil-blue uppercase tracking-wider w-16">Pos.</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-unifil-blue uppercase tracking-wider">Aluno</th>
                <th class="px-6 py-4 text-center text-xs font-semibold text-unifil-blue uppercase tracking-wider">Nível</th>
                <th class="px-6 py-4 text-right text-xs font-semibold text-unifil-blue uppercase tracking-wider">XP Total</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($users as $index => $user)
                @php $position = $startPosition + $index; @endphp
                <tr class="hover:bg-orange-50/50 transition-colors group">
                    {{-- Posição --}}
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-600 font-bold text-sm group-hover:bg-unifil-orange group-hover:text-white transition-colors">
                            {{ $position }}
                        </span>
                    </td>
                    
                    {{-- Aluno --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-unifil-orange to-orange-400 flex items-center justify-center text-white font-bold overflow-hidden flex-shrink-0">
                                @if ($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $user->name }}</p>
                                <p class="text-xs text-slate-400">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    
                    {{-- Nível --}}
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-unifil-blue/10 text-unifil-blue font-bold text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                            </svg>
                            {{ $user->current_level }}
                        </span>
                    </td>
                    
                    {{-- XP --}}
                    <td class="px-6 py-4 text-right">
                        <span class="font-bold text-unifil-orange text-lg">
                            {{ number_format($user->current_xp, 0, ',', '.') }}
                        </span>
                        <span class="text-xs text-slate-400 ml-1">XP</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Nenhum participante no ranking ainda.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
