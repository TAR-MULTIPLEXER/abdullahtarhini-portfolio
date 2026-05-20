<div id="projectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
    <div class="min-h-screen px-4 text-center flex items-center justify-center">
        <div class="inline-block w-full max-w-4xl text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl overflow-hidden">
            
            <!-- Close Button -->
            <button onclick="closeModal()" class="absolute top-4 right-4 z-10 bg-white rounded-full p-2 hover:bg-gray-100 shadow-lg">
                <i class="fas fa-times text-xl text-slate-600"></i>
            </button>
            
            <!-- Image Gallery -->
            <div class="relative h-96 bg-gray-100">
                <img id="modalImage" src="" class="w-full h-full object-cover">
            </div>
            
            <div class="p-8">
                <div class="flex items-center gap-3 mb-4">
                    <h2 id="modalTitle" class="text-3xl font-bold text-primary"></h2>
                    <span id="modalType" class="px-3 py-1 text-xs font-bold rounded-full text-white"></span>
                </div>
                
                <span id="modalCategory" class="text-accent font-semibold"></span>
                
                <div class="mt-6 prose max-w-none">
                    <h3 class="text-xl font-bold mb-3 text-primary">Description</h3>
                    <div id="modalDescription" class="text-gray-600"></div>
                    
                    <h3 class="text-xl font-bold mt-6 mb-3 text-primary">Technologies Used</h3>
                    <div id="modalTech" class="flex flex-wrap gap-2"></div>
                    
                    <div id="modalSpecsContainer">
                        <h3 class="text-xl font-bold mt-6 mb-3 text-primary">Technical Specifications</h3>
                        <div id="modalSpecs" class="bg-gray-50 p-4 rounded-lg"></div>
                    </div>
                    
                    <div id="modalLinks" class="mt-8 flex gap-4">
                        <button onclick="closeModal()" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 rounded-lg font-semibold transition">
                            Close
                        </button>
                        <a href="mailto:your.email@example.com?subject=Demo Request" 
                           class="px-6 py-3 bg-accent hover:bg-cyan-600 text-white rounded-lg font-semibold transition">
                            Request Demo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showProjectDetails(projectId, title, category, type, description, tools, image) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalCategory').textContent = category;
    document.getElementById('modalDescription').innerHTML = description;
    document.getElementById('modalImage').src = image;
    
    // Set type badge color
    const typeColors = {
        'hardware': 'bg-orange-500',
        'desktop': 'bg-purple-500',
        'telecom': 'bg-blue-600',
        'web': 'bg-cyan-500'
    };
    const typeBadge = document.getElementById('modalType');
    typeBadge.textContent = type.charAt(0).toUpperCase() + type.slice(1);
    typeBadge.className = `px-3 py-1 text-xs font-bold rounded-full text-white ${typeColors[type] || 'bg-cyan-500'}`;
    
    // Set technologies
    const techContainer = document.getElementById('modalTech');
    techContainer.innerHTML = '';
    if (tools) {
        tools.split(',').forEach(tool => {
            if (tool.trim()) {
                const span = document.createElement('span');
                span.className = 'px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded';
                span.textContent = tool.trim();
                techContainer.appendChild(span);
            }
        });
    }
    
    document.getElementById('projectModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('projectModal').classList.add('hidden');
}
</script>