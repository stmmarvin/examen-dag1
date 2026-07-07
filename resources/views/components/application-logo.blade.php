<svg {{ $attributes }} viewBox="0 0 1000 800" xmlns="http://www.w3.org/2000/svg">
    <!-- Scissor icon frame -->
    <g transform="translate(250, 150)">
        <!-- Frame -->
        <path d="M 0 0 L 0 350 L 300 350 L 300 280 L 380 280 L 380 230 L 450 230 L 450 0 Z" 
              fill="none" stroke="#1E293B" stroke-width="40" stroke-linecap="round" stroke-linejoin="round"/>
        
        <!-- Computer screen -->
        <rect x="380" y="230" width="80" height="60" fill="none" stroke="#1E293B" stroke-width="20" rx="5"/>
        
        <!-- Scissors -->
        <g transform="translate(150, 180)">
            <!-- Left blade -->
            <path d="M -60 -80 L -10 0 L -60 10 Z" fill="#1E293B"/>
            <!-- Right blade -->
            <path d="M 60 -80 L 10 0 L 60 10 Z" fill="#1E293B"/>
            <!-- Center dot -->
            <circle cx="0" cy="0" r="15" fill="#1E293B"/>
            <!-- Left handle -->
            <circle cx="-55" cy="-40" r="25" fill="none" stroke="#1E293B" stroke-width="12"/>
            <!-- Right handle -->
            <circle cx="55" cy="-40" r="25" fill="none" stroke="#1E293B" stroke-width="12"/>
        </g>
        
        <!-- Bottom dot -->
        <circle cx="150" cy="410" r="15" fill="#1E293B"/>
    </g>
    
    <!-- Text: kniploket -->
    <g transform="translate(80, 620)">
        <!-- knip (dark blue) -->
        <text x="0" y="0" font-family="Arial, sans-serif" font-size="140" font-weight="bold" fill="#1E293B">knip</text>
        <!-- loket (gold) -->
        <text x="320" y="0" font-family="Arial, sans-serif" font-size="140" font-weight="bold" fill="#B8935A">loket</text>
    </g>
    
    <!-- Text: tiko -->
    <g transform="translate(280, 750)">
        <!-- Lines -->
        <line x1="-110" y1="-20" x2="0" y2="-20" stroke="#B8935A" stroke-width="4"/>
        <line x1="280" y1="-20" x2="390" y2="-20" stroke="#B8935A" stroke-width="4"/>
        <!-- tiko text -->
        <text x="0" y="0" font-family="Arial, sans-serif" font-size="100" font-weight="normal" fill="#1E293B" letter-spacing="20">tiko</text>
    </g>
</svg>

