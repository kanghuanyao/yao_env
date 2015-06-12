set nopaste
set laststatus=2
syntax on
" set cursorline
set ignorecase
set showmatch
set showcmd
set nonu
set autoindent
set cindent
set shiftwidth=2
set smartindent
set tabstop=2

" No error bell
set noerrorbells visualbell t_vb=
autocmd GUIEnter * set visualbell t_vb=

highlight User1 ctermfg=red
highlight User2 term=underline cterm=underline ctermfg=green
highlight User3 term=underline cterm=underline ctermfg=yellow 
highlight User4 term=underline cterm=underline ctermfg=white
highlight User5 ctermfg=cyan
highlight User6 ctermfg=white

" file encoding. 
set encoding=utf-8
set fileencodings=utf-8,cp950


set statusline=%4*%<\ %1*[%F]
set statusline+=%4*\ %5*[%{&encoding},
set statusline+=%{&fileformat}]%m
set statusline+=%4*%=\ %6*%y%4*\ %3*%l%4*,\ %3*%c%4*\ \<\ %2*%P%4*\ \>


:nmap n nzz  
:nmap p pzz

