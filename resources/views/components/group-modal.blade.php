<div
    x-data="{
        open: false,
        group: null,
        isEditing: false,
        editedName: '',
        copied: false,
        
        openModal(data) {
            this.group = data.group;
            this.editedName = this.group.nome;
            this.isEditing = false;
            this.open = true;
            document.body.classList.add('overflow-hidden');
        },
        
        closeModal() {
            this.open = false;
            this.isEditing = false;
            document.body.classList.remove('overflow-hidden');
        },
        
        startEditing() {
            this.editedName = this.group.nome;
            this.isEditing = true;
            this.$nextTick(() => this.$refs.nameInput?.focus());
        },
        
        saveName() {
            // Simular salvamento (implementar axios.put posteriormente)
            this.group.nome = this.editedName;
            this.isEditing = false;
            // TODO: axios.put(`/api/grupos/${this.group.id}`, { nome: this.editedName })
        },
        
        copyCode() {
            navigator.clipboard.writeText(this.group.codigo);
            this.copied = true;
            setTimeout(() => this.copied = false, 2000);
        },
        
        isLeader(memberId) {
            return this.group && this.group.lider_id === memberId;
        }
    }"
    @open-group-modal.window="openModal($event.detail)"
    @keydown.escape.window="closeModal()"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50"
    style="display: none;"
>
    {{-- Overlay --}}
    <div 
        x-show="open"
        x-transition:enter="transition-opacity ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="closeModal()"
        class="fixed inset-0 bg-slate-900/80 backdrop-blur-md"
    ></div>

    {{-- Modal Panel --}}
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto p-4 sm:p-6">
        <div class="flex min-h-full items-center justify-center">
            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-8"
                @click.stop
                class="relative w-full max-w-lg"
            >
                {{-- Card com Glassmorphism --}}
                <div class="relative bg-slate-900/90 backdrop-blur-xl rounded-3xl border border-white/10 shadow-2xl shadow-violet-500/10 overflow-hidden">
                    
                    {{-- Efeitos de fundo --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-violet-600/5 via-transparent to-fuchsia-600/5"></div>
                    <div class="absolute -top-32 -right-32 w-64 h-64 bg-gradient-to-br from-violet-500/20 to-fuchsia-500/20 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-32 -left-32 w-64 h-64 bg-gradient-to-br from-primary/20 to-orange-500/20 rounded-full blur-3xl"></div>
                    
                    {{-- Header --}}
                    <div class="relative z-10 px-6 py-5 border-b border-white/10 flex items-center justify-between">
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            {{-- Ícone do Grupo --}}
                            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-violet-500 to-fuchsia-500 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-violet-500/30 flex-shrink-0">
                                <template x-if="group">
                                    <span x-text="group.nome.substring(0, 2).toUpperCase()"></span>
                                </template>
                            </div>
                            
                            {{-- Nome (Editável) --}}
                            <div class="flex-1 min-w-0">
                                <template x-if="!isEditing">
                                    <div class="flex items-center gap-2">
                                        <h2 class="text-xl font-bold text-white truncate" x-text="group?.nome"></h2>
                                        <button 
                                            @click="startEditing()"
                                            class="p-1.5 text-white/40 hover:text-white hover:bg-white/10 rounded-lg transition-colors"
                                            title="Editar nome"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                                <template x-if="isEditing">
                                    <div class="flex items-center gap-2">
                                        <input 
                                            type="text"
                                            x-model="editedName"
                                            x-ref="nameInput"
                                            @keydown.enter="saveName()"
                                            @keydown.escape="isEditing = false"
                                            class="flex-1 px-3 py-1.5 bg-white/10 border border-white/20 rounded-lg text-white text-lg font-bold focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent"
                                        >
                                        <button 
                                            @click="saveName()"
                                            class="p-1.5 text-green-400 hover:bg-green-500/20 rounded-lg transition-colors"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                        <button 
                                            @click="isEditing = false"
                                            class="p-1.5 text-red-400 hover:bg-red-500/20 rounded-lg transition-colors"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                                <p class="text-sm text-white/50 mt-0.5" x-text="group?.hackathon?.nome"></p>
                            </div>
                        </div>

                        {{-- Botão Fechar --}}
                        <button 
                            @click="closeModal()"
                            class="p-2 text-white/40 hover:text-white hover:bg-white/10 rounded-xl transition-colors"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Corpo --}}
                    <div class="relative z-10 px-6 py-6 space-y-6">
                        
                        {{-- Código do Grupo --}}
                        <div class="p-4 bg-white/5 rounded-2xl border border-white/10">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-white/40 uppercase tracking-wider mb-1">Código do Grupo</p>
                                    <p class="text-2xl font-mono font-bold text-white flex items-center gap-1">
                                        <span class="text-primary">#</span>
                                        <span x-text="group?.codigo"></span>
                                    </p>
                                </div>
                                <button 
                                    @click="copyCode()"
                                    class="p-3 rounded-xl transition-all"
                                    :class="copied ? 'bg-green-500/20 text-green-400' : 'bg-white/5 text-white/60 hover:bg-white/10 hover:text-white'"
                                >
                                    <template x-if="!copied">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </template>
                                    <template x-if="copied">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </template>
                                </button>
                            </div>
                            <p class="text-xs text-white/30 mt-2">Compartilhe este código para outros membros entrarem no grupo</p>
                        </div>

                        {{-- Lista de Membros --}}
                        <div>
                            <p class="text-xs text-white/40 uppercase tracking-wider mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Membros do Grupo
                            </p>
                            
                            <div class="space-y-2 max-h-64 overflow-y-auto pr-2 custom-scrollbar">
                                <template x-for="member in group?.membros" :key="member.id">
                                    <div class="flex items-center gap-4 p-3 bg-white/5 rounded-xl border border-white/5 hover:bg-white/10 hover:border-white/10 transition-all group/member">
                                        {{-- Avatar --}}
                                        <div class="relative h-11 w-11 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold overflow-hidden flex-shrink-0">
                                            <template x-if="member.avatar">
                                                <img :src="'/storage/' + member.avatar" :alt="member.name" class="w-full h-full object-cover">
                                            </template>
                                            <template x-if="!member.avatar">
                                                <span x-text="member.name.charAt(0).toUpperCase()"></span>
                                            </template>
                                            {{-- Indicador de líder --}}
                                            <template x-if="isLeader(member.id)">
                                                <div class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-primary rounded-full flex items-center justify-center ring-2 ring-slate-900">
                                                    <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </div>
                                            </template>
                                        </div>

                                        {{-- Info --}}
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-white truncate" x-text="member.name"></p>
                                            <p class="text-sm text-white/50 truncate" x-text="member.email"></p>
                                        </div>

                                        {{-- Badge de Líder --}}
                                        <template x-if="isLeader(member.id)">
                                            <span class="px-3 py-1 bg-gradient-to-r from-primary to-orange-400 text-white text-xs font-bold rounded-full shadow-lg shadow-orange-500/20 flex-shrink-0">
                                                Líder
                                            </span>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="relative z-10 px-6 py-4 border-t border-white/10 bg-white/5 flex justify-end gap-3">
                        <button 
                            @click="closeModal()"
                            class="px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white font-medium rounded-xl border border-white/10 transition-all"
                        >
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 3px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }
</style>
