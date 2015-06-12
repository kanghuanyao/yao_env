
if [ "$yao_env_path" == "" ] ; then
	echo "yao_env_path is not exported."
fi

if [ "$TERM" != "screen" ]; then
	EXE_PATH="$yao_env_path/bin $HOME/local/bin"
	for i in $EXE_PATH ; do
		if [ -e "$i" ] ; then
			export PATH="$i:$PATH"
		fi
	done
fi

export LANG=en_us
export LC_ALL=C
export SVN_EDITOR="/usr/bin/vim"

PS1="${debian_chroot:+($debian_chroot)}\[\033[01;32m\]\u\[\033[00m\]:\[\033[01;36m\]\w\[\033[00m\]\$ "

alias ls='ls --color=auto'
alias l='ls -Al'
alias shutdown='echo "Permission Denied!! "'
alias reboot='echo "Permission Denied!! "'
alias svndiff='svn diff -x -w'
alias vi='vim'
alias maketags='ctags -R -f .tags -h ".c.h.php.js"'
alias rm='nice -n 19 rm'
alias less='less -r'

alias grep='grep -s --color=auto --exclude-dir=.svn --exclude-dir=.git --binary-files=without-match'

if [ "$TERM" = "screen" ]; then
	PROMPT_COMMAND="printf '\a'"
	screen_set_window_title () 
	{
		local HPWD=$(echo $PWD | sed 's/^.*\///g')
		printf '\ek%s\e\\' "$HPWD"
	}
	PROMPT_COMMAND="screen_set_window_title; $PROMPT_COMMAND"
fi

if [ "$TERM" = "xterm" ]; then
	export TERM=xterm-256color
fi
OLD_PATH=$PATH
function resetEnv
{
	
	unset TPATH_UC
	unset TPATH_LIBTGZ
	unset TPATH_UCLIBC

	export PATH=$OLD_PATH
}


