<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedGrader: {{ $activity->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50 h-screen overflow-hidden flex flex-col font-sans">
    
    {{-- Main App: wraps header + content so gradedCount is in scope --}}
    <div x-data="speedGrader(@js($studentsData), '{{ route('speedgrader.save', [$course, $activity]) }}')" class="flex flex-col h-full">

    {{-- Header --}}
    <header class="bg-mzl-blue text-white h-16 shrink-0 flex justify-between items-center px-4 shadow-md z-10" style="background: linear-gradient(135deg, #0CB29C 0%, #3650BB 100%);">
        <div class="flex items-center gap-4">
            <a href="{{ route('my-courses.manage', $course) }}" class="p-2 bg-white/10 hover:bg-white/20 rounded-xl transition" title="Volver a los cursos">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="font-black text-lg leading-none" style="text-shadow: 0 1px 2px rgba(0,0,0,0.1);">SpeedGrader: {{ $activity->title }}</h1>
                <p class="text-xs text-white/80 mt-0.5">{{ $course->title }} • Max: {{ $activity->max_grade }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="text-sm font-bold bg-white/20 border border-white/10 px-4 py-1.5 rounded-full shadow-inner flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                <span x-text="gradedCount"></span><span> / {{ count($studentsData) }} Evaluados</span>
            </div>
        </div>
    </header>

    {{-- Content --}}
    <div class="flex flex-1 overflow-hidden">
        {{-- Sidebar --}}
        <div class="w-80 bg-white border-r border-gray-200 flex flex-col shrink-0 shadow-[4px_0_24px_rgba(0,0,0,0.02)] z-0">
            <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                <div class="relative">
                    <svg class="w-4 h-4 absolute left-3 top-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" x-model="search" placeholder="Buscar estudiante..." class="w-full text-sm rounded-xl border-gray-200 focus:ring-mzl-teal focus:border-mzl-teal py-2.5 pl-9 shadow-sm">
                </div>
            </div>
            
            <div class="flex-1 overflow-y-auto p-3 space-y-1.5 custom-scrollbar">
                <template x-for="(student, index) in filteredStudents" :key="student.enrollment_id">
                    <button @click="selectStudent(index)" 
                            :class="{'bg-mzl-teal/10 border-mzl-teal shadow-sm': currentIndex === index, 'hover:bg-gray-50 border-transparent text-gray-700': currentIndex !== index}"
                            class="w-full text-left px-3 py-3 rounded-2xl border-2 flex items-center gap-3 transition">
                        
                        <div class="relative shrink-0">
                            <img :src="student.student_avatar" class="w-10 h-10 rounded-full border bg-white object-cover">
                            <div x-show="student.is_graded" class="absolute -bottom-1 -right-1 bg-green-500 text-white rounded-full p-0.5 border-2 border-white shadow-sm">
                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </div>

                        <div class="flex-1 overflow-hidden">
                            <p :class="currentIndex === index ? 'font-black text-mzl-teal' : 'font-bold'" class="text-sm truncate leading-tight" x-text="student.student_name"></p>
                            <p class="text-[10px] text-gray-400 truncate mt-0.5" x-text="student.is_graded ? 'Nota: '+student.score : 'Pendiente'"></p>
                        </div>
                    </button>
                </template>
                
                <template x-if="filteredStudents.length === 0">
                    <div class="text-center py-10 opacity-50">
                        <p class="text-xs font-bold text-gray-500">No se encontraron resultados.</p>
                    </div>
                </template>
            </div>
        </div>

        {{-- Grading Area --}}
        <div class="flex-1 flex flex-col bg-gray-50 overflow-hidden relative">
            <template x-if="activeStudent">
                <div class="h-full flex flex-col relative">
                    
                    {{-- Alert Messages --}}
                    <div class="absolute inset-x-0 top-0 z-10 flex justify-center p-4 pt-6 pointer-events-none">
                        <div x-show="showSavedBadge" x-transition.opacity.duration.300ms class="bg-green-500 text-white font-bold px-6 py-3 rounded-full shadow-lg border-2 border-green-400 flex items-center gap-2 transform translate-y-0 pointer-events-auto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> ¡Nota guardada correctamente!
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto p-6 md:p-10">
                        <div class="max-w-3xl mx-auto bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 md:p-12">
                            
                            {{-- Student Profile --}}
                            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 mb-10 border-b border-gray-100 pb-10 text-center sm:text-left">
                                <img :src="activeStudent.student_avatar" class="w-24 h-24 rounded-full border-4 border-gray-50 shadow-sm object-cover">
                                <div class="mt-2">
                                    <h2 class="text-3xl font-black text-gray-900 leading-tight" x-text="activeStudent.student_name"></h2>
                                    <p class="text-mzl-blue font-bold tracking-wide text-sm mt-1" x-text="activeStudent.student_email"></p>
                                </div>
                            </div>
                            
                            {{-- Grading Form --}}
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                                
                                {{-- Score Column --}}
                                <div class="md:col-span-4 flex flex-col items-center sm:items-start">
                                    <label class="block font-black text-gray-800 text-lg mb-3">
                                        Calificación
                                    </label>
                                    <div class="relative group">
                                        <input type="number" step="0.1" max="{{ $activity->max_grade }}" min="0" x-model.number="formScore" 
                                               @keydown.enter.prevent="saveAndNext"
                                               class="w-32 text-4xl font-black text-center rounded-2xl border-2 border-gray-200 focus:ring-mzl-teal focus:border-mzl-teal py-4 text-mzl-teal shadow-inner transition placeholder-gray-200" placeholder="0.0">
                                        <span class="absolute right-[-4rem] top-1/2 -translate-y-1/2 text-gray-400 font-bold text-xl select-none">/ {{ $activity->max_grade }}</span>
                                    </div>
                                    <p x-show="errorScore" class="text-mzl-pink text-sm font-bold mt-2 bg-mzl-pink/10 px-3 py-1 rounded-lg" x-text="errorScore"></p>
                                </div>
                                
                                {{-- Feedback Column --}}
                                <div class="md:col-span-8 flex flex-col">
                                    <label class="block font-black text-gray-800 text-lg mb-3 flex justify-between items-center">
                                        Retroalimentación
                                        <span class="text-xs font-bold text-gray-400 bg-gray-100 px-2 py-1 rounded-md uppercase">Opcional</span>
                                    </label>
                                    <textarea rows="5" x-model="formFeedback" 
                                              placeholder="Escribe comentarios, correcciones o felicitaciones..."
                                              class="w-full rounded-2xl border-2 border-gray-200 focus:ring-mzl-blue focus:border-mzl-blue resize-none py-3 px-4 text-gray-700 transition shadow-inner"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Action Footer --}}
                    <div class="bg-white border-t border-gray-200 px-6 py-4 shrink-0 flex items-center justify-between shadow-[0_-4px_24px_rgba(0,0,0,0.02)]">
                        <div class="flex items-center gap-3">
                            <button @click="selectStudent(currentIndex - 1)" :disabled="currentIndex === 0" 
                                    class="px-5 py-3 border-2 border-gray-200 rounded-xl font-bold text-gray-500 disabled:opacity-30 disabled:cursor-not-allowed hover:bg-gray-50 hover:text-gray-800 transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                Anterior
                            </button>
                        </div>

                        <button @click="saveAndNext" :disabled="isSaving" 
                                class="bg-mzl-blue text-white px-8 py-3.5 rounded-xl font-black text-lg shadow-lg shadow-mzl-blue/30 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-mzl-blue/40 transition-all disabled:opacity-50 disabled:hover:translate-y-0 flex items-center gap-2">
                            
                            <span x-show="!isSaving" x-text="currentIndex === filteredStudents.length - 1 ? 'Guardar y Finalizar' : 'Guardar y Siguiente'"></span>
                            <span x-show="isSaving">Guardando...</span>

                            <svg x-show="!isSaving && currentIndex < filteredStudents.length - 1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            <svg x-show="!isSaving && currentIndex === filteredStudents.length - 1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <svg x-show="isSaving" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </button>
                    </div>
                </div>
            </template>
            <template x-if="!activeStudent">
                <div class="h-full flex flex-col items-center justify-center text-gray-400">
                    <svg class="w-20 h-20 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <p class="font-bold text-lg">Selecciona un estudiante para comenzar.</p>
                </div>
            </template>
        </div>

    </div>{{-- end content --}}
    </div>{{-- end main Alpine scope --}}

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.02);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #d1d5db;
        }
    </style>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('speedGrader', (initialStudents, saveUrl) => ({
                // Deduplicate by user_id client-side as a safeguard
                students: [...new Map(initialStudents.map(s => [s.user_id, s])).values()],
                search: '',
                currentIndex: 0,
                formScore: '',
                formFeedback: '',
                isSaving: false,
                showSavedBadge: false,
                errorScore: '',
                badgeTimeout: null,
                
                init() {
                    // Start with first missing grade, or just first student
                    const firstUngraded = this.students.findIndex(s => !s.is_graded);
                    this.currentIndex = firstUngraded !== -1 ? firstUngraded : (this.students.length > 0 ? 0 : -1);
                    if(this.currentIndex !== -1) {
                        this.loadStudent(this.currentIndex);
                    }
                },
                
                get gradedCount() {
                    return this.students.filter(s => s.is_graded).length;
                },
                
                get filteredStudents() {
                    if (!this.search) return this.students;
                    return this.students.filter(s => s.student_name.toLowerCase().includes(this.search.toLowerCase()));
                },
                
                get activeStudent() {
                    return this.filteredStudents[this.currentIndex] || null;
                },
                
                selectStudent(index) {
                    if (index >= 0 && index < this.filteredStudents.length) {
                        if (this.badgeTimeout) { clearTimeout(this.badgeTimeout); this.showSavedBadge = false; }
                        this.currentIndex = index;
                        this.loadStudent(index);
                    }
                },
                
                loadStudent(index) {
                    const student = this.filteredStudents[index];
                    this.formScore = student.score !== null ? student.score : '';
                    this.formFeedback = student.feedback || '';
                    this.errorScore = '';
                },
                
                async saveAndNext() {
                    if (!this.activeStudent || this.isSaving) return;
                    
                    if (this.formScore === '' || isNaN(this.formScore) || this.formScore < 0 || this.formScore > {{ $activity->max_grade }}) {
                        this.errorScore = '⚠️ Ingresa una nota de 0 a {{ $activity->max_grade }}.';
                        return;
                    }
                    this.errorScore = '';
                    
                    this.isSaving = true;
                    if (this.badgeTimeout) { clearTimeout(this.badgeTimeout); }
                    this.showSavedBadge = false;
                    
                    try {
                        const response = await fetch(saveUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                enrollment_id: this.activeStudent.enrollment_id,
                                score: this.formScore,
                                feedback: this.formFeedback
                            })
                        });
                        
                        const data = await response.json();
                        
                        if (response.ok) {
                            // Update local array
                            const actId = this.activeStudent.enrollment_id;
                            const realStudent = this.students.find(s => s.enrollment_id === actId);
                            if (realStudent) {
                                realStudent.score = this.formScore;
                                realStudent.feedback = this.formFeedback;
                                realStudent.is_graded = true;
                            }
                            
                            this.showSavedBadge = true;
                            
                            // Visual transition before changing student
                            setTimeout(() => {
                                this.isSaving = false;
                                this.badgeTimeout = setTimeout(() => { this.showSavedBadge = false; }, 1500);
                                
                                // Auto next or finish
                                if (this.currentIndex < this.filteredStudents.length - 1) {
                                    this.selectStudent(this.currentIndex + 1);
                                } else {
                                    // It is the last student
                                    window.location.href = "{{ route('my-courses.manage', $course) }}";
                                }
                            }, 450);

                        } else {
                            this.errorScore = data.message || 'Error guardando en el servidor.';
                            this.isSaving = false;
                        }
                    } catch (err) {
                        this.errorScore = 'Error de conexión. Verifica tu internet.';
                        this.isSaving = false;
                    }
                }
            }));
        });
    </script>
</body>
</html>
