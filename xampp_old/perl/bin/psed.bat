@rem = '--*-Perl-*--
@echo off
if "%OS%" == "Windows_NT" goto WinNT
IF EXIST "%~dp0perl.exe" (
"%~dp0perl.exe" -x -S "%0" %1 %2 %3 %4 %5 %6 %7 %8 %9
) ELSE IF EXIST "%~dp0..\..\bin\perl.exe" (
"%~dp0..\..\bin\perl.exe" -x -S "%0" %1 %2 %3 %4 %5 %6 %7 %8 %9
) ELSE (
IF EXIST "%~dp0perl.exe" (
"%~dp0perl.exe" -x -S "%0" %1 %2 %3 %4 %5 %6 %7 %8 %9
) ELSE IF EXIST "%~dp0..\..\bin\perl.exe" (
"%~dp0..\..\bin\perl.exe" -x -S "%0" %1 %2 %3 %4 %5 %6 %7 %8 %9
) ELSE (
perl -x -S "%0" %1 %2 %3 %4 %5 %6 %7 %8 %9
)

)

goto endofperl
:WinNT
IF EXIST "%~dp0perl.exe" (
"%~dp0perl.exe" -x -S %0 %*
) ELSE IF EXIST "%~dp0..\..\bin\perl.exe" (
"%~dp0..\..\bin\perl.exe" -x -S %0 %*
) ELSE (
IF EXIST "%~dp0perl.exe" (
"%~dp0perl.exe" -x -S %0 %*
) ELSE IF EXIST "%~dp0..\..\bin\perl.exe" (
"%~dp0..\..\bin\perl.exe" -x -S %0 %*
) ELSE (
perl -x -S %0 %*
)

)

if NOT "%COMSPEC%" == "%SystemRoot%\system32\cmd.exe" goto endofperl
if %errorlevel% == 9009 echo You do not have Perl in your PATH.
if errorlevel 1 goto script_failed_so_exit_with_non_zero_val 2>nul
goto endofperl
@rem ';
#!perl
#line 43
    eval 'exec C:\xampp_old\perl\bin\perl.exe -S $0 ${1+"$@"}'
	if $running_under_some_shell;
my $startperl;
my $perlpath;
($startperl = <<'/../') =~ s/\s*\z//;
#!perl
/../
($perlpath = <<'/../') =~ s/\s*\z//;
C:\xampp_old\perl\bin\perl.exe
/../

$0 =~ s/^.*?(\w+)[\.\w]*$/$1/;

# (p)sed - a stream editor
# History:  Aug 12 2000: Original version.
#           Mar 25 2002: Rearrange generated Perl program.
#           Jul 23 2007: Fix bug in regex stripping (M.Thorland)

use strict;
use integer;
use Symbol;

=head1 NAME

psed - a stream editor

=head1 SYNOPSIS

   psed [-an] script [file ...]
   psed [-an] [-e script] [-f script-file] [file ...]

   s2p  [-an] [-e script] [-f script-file]

=head1 DESCRIPTION

A stream editor reads the input stream consisting of the specified files
(or standard input, if none are given), processes is line by line by
applying a script consisting of edit commands, and writes resulting lines
to standard output. The filename 'C<->' may be used to read standard input.

The edit script is composed from arguments of B<-e> options and
script-files, in the given order. A single script argument may be specified
as the first parameter.

If this program is invoked with the name F<s2p>, it will act as a
sed-to-Perl translator. See L<"SED SCRIPT TRANSLATION">.

B<sed> returns an exit code of 0 on success or >0 if an error occurred.

=head1 OPTIONS

=over 4

=item B<-a>

A file specified as argument to the B<w> edit command is by default
opened before input processing starts. Using B<-a>, opening of such
files is delayed until the first line is actually written to the file.

=item B<-e> I<script>

The editing commands defined by I<script> are appended to the script.
Multiple commands must be separated by newlines.

=item B<-f> I<script-file>

Editing commands from the specified I<script-file> are read and appended
to the script.

=item B<-n>

By default, a line is written to standard output after the editing script
has been applied to it. The B<-n> option suppresses automatic printing.

=back

=head1 COMMANDS

B<sed> command syntax is defined as

Z<> Z<> Z<> Z<>[I<address>[B<,>I<address>]][B<!>]I<function>[I<argument>]

with whitespace being permitted before or after addresses, and between
the function character and the argument. The I<address>es and the
address inverter (C<!>) are used to restrict the application of a
command to the selected line(s) of input.

Each command must be on a line of its own, except where noted in
the synopses below.

The edit cycle performed on each input line consist of reading the line
(without its trailing newline character) into the I<pattern space>,
applying the applicable commands of the edit script, writing the final
contents of the pattern space and a newline to the standard output.
A I<hold space> is provided for saving the contents of the
pattern space for later use.

=head2 Addresses

A sed address is either a line number or a pattern, which may be combined
arbitrarily to construct ranges. Lines are numbered across all input files.

Any address may be followed by an exclamation mark ('C<!>'), selecting
all lines not matching that address.

=over 4

=item I<number>

The line with the given number is selected.

=item B<$>

A dollar sign (C<$>) is the line number of the last line of the input stream.

=item B</>I<regular expression>B</>

A pattern address is a basic regular expression (see 
L<"BASIC REGULAR EXPRESSIONS">), between the delimiting character C</>.
Any other character except C<\> or newline may be used to delimit a
pattern address when the initial delimiter is prefixed with a
backslash ('C<\>').

=back

If no address is given, the command selects every line.

If one address is given, it selects the line (or lines) matching the
address.

Two addresses select a range that begins whenever the first address
matches, and ends (including that line) when the second address matches.
If the first (second) address is a matching pattern, the second 
address is not applied to the very same line to determine the end of
the range. Likewise, if the second address is a matching pattern, the
first address is not applied to the very same line to determine the
begin of another range. If both addresses are line numbers,
and the second line number is less than the first line number, then
only the first line is selected.


=head2 Functions

The maximum permitted number of addresses is indicated with each
function synopsis below.

The argument I<text> consists of one or more lines following the command.
Embedded newlines in I<text> must be preceded with a backslash.  Other
backslashes in I<text> are deleted and the following character is taken
literally.

=over 4

=cut

my %ComTab;
my %GenKey;
#--------------------------------------------------------------------------
$ComTab{'a'}=[ 1, 'txt', \&Emit,       '{ push( @Q, <<'."'TheEnd' ) }\n" ]; #ok

=item [1addr]B<a\> I<text>

Write I<text> (which must start on the line following the command)
to standard output immediately before reading the next line
of input, either by executing the B<N> function or by beginning a new cycle.

=cut

#--------------------------------------------------------------------------
$ComTab{'b'}=[ 2, 'str', \&Branch,     '{ goto XXX; }'                   ]; #ok

=item [2addr]B<b> [I<label>]

Branch to the B<:> function with the specified I<label>. If no label
is given, branch to the end of the script.

=cut

#--------------------------------------------------------------------------
$ComTab{'c'}=[ 2, 'txt', \&Change,     <<'-X-'                           ]; #ok
{ print <<'TheEnd'; } $doPrint = 0; goto EOS;
-X-
### continue OK => next CYCLE;

=item [2addr]B<c\> I<text>

The line, or range of lines, selected by the address is deleted. 
The I<text> (which must start on the line following the command)
is written to standard output. With an address range, this occurs at
the end of the range.

=cut

#--------------------------------------------------------------------------
$ComTab{'d'}=[ 2, '',    \&Emit,       <<'-X-'                           ]; #ok
{ $doPrint = 0;
  goto EOS;
}
-X-
### continue OK => next CYCLE;

=item [2addr]B<d>

Deletes the pattern space and starts the next cycle.

=cut

#--------------------------------------------------------------------------
$ComTab{'D'}=[ 2, '',    \&Emit,       <<'-X-'                           ]; #ok
{ s/^.*\n?//;
  if(length($_)){ goto BOS } else { goto EOS }
}
-X-
### continue OK => next CYCLE;

=item [2addr]B<D>

Deletes the pattern space through the first embedded newline or to the end.
If the pattern space becomes empty, a new cycle is started, otherwise
execution of the script is restarted.

=cut

#--------------------------------------------------------------------------
$ComTab{'g'}=[ 2, '',    \&Emit,       '{ $_ = $Hold };'                 ]; #ok

=item [2addr]B<g>

Replace the contents of the pattern space with the hold space.

=cut

#--------------------------------------------------------------------------
$ComTab{'G'}=[ 2, '',    \&Emit,       '{ $_ .= "\n"; $_ .= $Hold };'    ]; #ok

=item [2addr]B<G>

Append a newline and the contents of the hold space to the pattern space.

=cut

#--------------------------------------------------------------------------
$ComTab{'h'}=[ 2, '',    \&Emit,       '{ $Hold = $_ }'                  ]; #ok

=item [2addr]B<h>

Replace the contents of the hold space with the pattern space.

=cut

#--------------------------------------------------------------------------
$ComTab{'H'}=[ 2, '',    \&Emit,       '{ $Hold .= "\n"; $Hold .= $_; }' ]; #ok

=item [2addr]B<H>

Append a newline and the contents of the pattern space to the hold space.

=cut

#--------------------------------------------------------------------------
$ComTab{'i'}=[ 1, 'txt', \&Emit,       '{ print <<'."'TheEnd' }\n"       ]; #ok

=item [1addr]B<i\> I<text>

Write the I<text> (which must start on the line following the command)
to standard output.

=cut

#--------------------------------------------------------------------------
$ComTab{'l'}=[ 2, '',    \&Emit,       '{ _l() }'                        ]; #okUTF8

=item [2addr]B<l>

Print the contents of the pattern space: non-printable characters are
shown in C-style escaped form; long lines are split and have a trailing
^'C<\>' at the point of the split; the true end of a line is marked with
a 'C<$>'. Escapes are: '\a', '\t', '\n', '\f', '\r', '\e' for
BEL, HT, LF, FF, CR, ESC, respectively, and '\' followed by a three-digit
octal number for all other non-printable characters.

=cut

#--------------------------------------------------------------------------
$ComTab{'n'}=[ 2, '',    \&Emit,       <<'-X-'                           ]; #ok
{ print $_, "\n" if $doPrint;
  printQ() if @Q;
  $CondReg = 0;
  last CYCLE unless getsARGV();
  chomp();
}
-X-

=item [2addr]B<n>

If automatic printing is enabled, write the pattern space to the standard
output. Replace the pattern space with the next line of input. If
there is no more input, processing is terminated.

=cut

#--------------------------------------------------------------------------
$ComTab{'N'}=[ 2, '',    \&Emit,       <<'-X-'                           ]; #ok
{ printQ() if @Q;
  $CondReg = 0;
  last CYCLE unless getsARGV( $h );
  chomp( $h );
  $_ .= "\n$h";
}
-X-

=item [2addr]B<N>

Append a newline and the next line of input to the pattern space. If
there is no more input, processing is terminated.

=cut

#--------------------------------------------------------------------------
$ComTab{'p'}=[ 2, '',    \&Emit,       '{ print $_, "\n"; }'             ]; #ok

=item [2addr]B<p>

Print the pattern space to the standard output. (Use the B<-n> option
to suppress automatic printing at the end of a cycle if you want to
avoid double printing of lines.)

=cut

#--------------------------------------------------------------------------
$ComTab{'P'}=[ 2, '',    \&Emit,       <<'-X-'                           ]; #ok
{ if( /^(.*)/ ){ print $1, "\n"; } }
-X-

=item [2addr]B<P>

Prints the pattern space through the first embedded newline or to the end.

=cut

#--------------------------------------------------------------------------
$ComTab{'q'}=[ 1, '',    \&Emit,       <<'-X-'                           ]; #ok
{ print $_, "\n" if $doPrint;
  last CYCLE;
}
-X-

=item [1addr]B<q>

Branch to the end of the script and quit without starting a new cycle.

=cut

#--------------------------------------------------------------------------
$ComTab{'r'}=[ 1, 'str', \&Emit,       "{ _r( '-X-' ) }"                 ]; #ok

=item [1addr]B<r> I<file>

Copy the contents of the I<file> to standard output immediately before
the next attempt to read a line of input. Any error encountered while
reading I<file> is silently ignored.

=cut

#--------------------------------------------------------------------------
$ComTab{'s'}=[ 2, 'sub', \&Emit,       ''                                ]; #ok

=item [2addr]B<s/>I<regular expression>B</>I<replacement>B</>I<flags>

Substitute the I<replacement> string for the first substring in
the pattern space that matches the I<regular expression>.
Any character other than backslash or newline can be used instead of a 
slash to delimit the regular expression and the replacement.
To use the delimiter as a literal character within the regular expression
and the replacement, precede the character by a backslash ('C<\>').

Literal newlines may be embedded in the replacement string by
preceding a newline with a backslash.

Within the replacement, an ampersand ('C<&>') is replaced by the string
matching the regular expression. The strings 'C<\1>' through 'C<\9>' are
replaced by the corresponding subpattern (see L<"BASIC REGULAR EXPRESSIONS">).
To get a literal 'C<&>' or 'C<\>' in the replacement text, precede it
by a backslash.

The following I<flags> modify the behaviour of the B<s> command:

=over 8

=item B<g>

The replacement is performed for all matching, non-overlapping substrings
of the pattern space.

=item B<1>..B<9>

Replace only the n-th matching substring of the pattern space.

=item B<p>

If the substitution was made, print the new value of the pattern space.

=item B<w> I<file>

If the substitution was made, write the new value of the pattern space
to the specified file.

=back

=cut

#--------------------------------------------------------------------------
$ComTab{'t'}=[ 2, 'str', \&Branch,     '{ goto XXX if _t() }'            ]; #ok

=item [2addr]B<t> [I<label>]

Branch to the B<:> function with the specified I<label> if any B<s>
substitutions have been made since the most recent reading of an input line
or execution of a B<t> function. If no label is given, branch to the end of
the script. 


=cut

#--------------------------------------------------------------------------
$ComTab{'w'}=[ 2, 'str', \&Write,      "{ _w( '-X-' ) }"                 ]; #ok

=item [2addr]B<w> I<file>

The contents of the pattern space are written to the I<file>.

=cut

#--------------------------------------------------------------------------
$ComTab{'x'}=[ 2, '',    \&Emit,       '{ ($Hold, $_) = ($_, $Hold) }'   ]; #ok

=item [2addr]B<x>

Swap the contents of the pattern space and the hold space.

=cut

#--------------------------------------------------------------------------
$ComTab{'y'}=[ 2, 'tra', \&Emit,       ''                                ]; #ok

=item [2addr]B<y>B</>I<string1>B</>I<string2>B</>

In the pattern space, replace all characters occurring in I<string1> by the
character at the corresponding position in I<string2>. It is possible
to use any character (other than a backslash or newline) instead of a
slash to delimit the strings.  Within I<string1> and I<string2>, a
backslash followed by any character other than a newline is that literal
character, and a backslash followed by an 'n' is replaced by a newline
character.

=cut

#--------------------------------------------------------------------------
$ComTab{'='}=[ 1, '',    \&Emit,       '{ print "$.\n" }'                ]; #ok

=item [1addr]B<=>

Prints the current line number on the standard output.

=cut

#--------------------------------------------------------------------------
$ComTab{':'}=[ 0, 'str', \&Label,      ''                                ]; #ok

=item [0addr]B<:> [I<label>]

The command specifies the position of the I<label>. It has no other effect.

=cut

#--------------------------------------------------------------------------
$ComTab{'{'}=[ 2, '',    \&BeginBlock, '{'                               ]; #ok
$ComTab{'}'}=[ 0, '',    \&EndBlock,   ';}'                              ]; #ok
# ';' to avoid warning on empty {}-block

=item [2addr]B<{> [I<command>]

=item [0addr]B<}>

These two commands begin and end a command list. The first command may
be given on the same line as the opening B<{> command. The commands
within the list are jointly selected by the address(es) given on the
B<{> command (but may still have individual addresses).

=cut

#--------------------------------------------------------------------------
$ComTab{'#'}=[ 0, 'str', \&Comment,    ''                                ]; #ok

=item [0addr]B<#> [I<comment>]

The entire line is ignored (treated as a comment). If, however, the first
two characters in the script are 'C<#n>', automatic printing of output is
suppressed, as if the B<-n> option were given on the command line.

=back

=cut

use vars qw{ $isEOF $Hold %wFiles @Q $CondReg $doPrint };

my $useDEBUG    = exists( $ENV{PSEDDEBUG} );
my $useEXTBRE   = $ENV{PSEDEXTBRE} || '';
$useEXTBRE =~ s/[^<>wWyB]//g; # gawk RE's handle these

my $doAutoPrint = 1;          # automatic printing of pattern space (-n => 0)
my $doOpenWrite = 1;          # open w command output files at start (-a => 0)
my $svOpenWrite = 0;          # save $doOpenWrite

# lower case $0 below as a VMSism.  The VMS build procedure creates the
# s2p file traditionally in upper case on the disk.  When VMS is in a
# case preserved or case sensitive mode, $0 will be returned in the exact
# case which will be on the disk, and that is not predictable at this time.

my $doGenerate  = lc($0) eq 's2p';

# Collected and compiled script
#
my( @Commands, %Defined, @BlockStack, %Label, $labNum, $Code, $Func );
$Code = '';

##################
#  Compile Time
#
# Labels
# 
# Error handling
#
sub Warn($;$){
    my( $msg, $loc ) = @_;
    $loc ||= '';
    $loc .= ': ' if length( $loc );
    warn( "$0: $loc$msg\n" );
}

$labNum = 0;
sub newLabel(){
    return 'L_'.++$labNum;
}

# safeHere: create safe here delimiter and  modify opcode and argument
#
sub safeHere($$){
    my( $codref, $argref ) = @_;
    my $eod = 'EOD000';
    while( $$argref =~ /^$eod$/m ){
        $eod++;
    }
    $$codref =~ s/TheEnd/$eod/e;
    $$argref .= "$eod\n"; 
}

# Emit: create address logic and emit command
#
sub Emit($$$$$$){
    my( $addr1, $addr2, $negated, $opcode, $arg, $fl ) = @_;
    my $cond = '';
    if( defined( $addr1 ) ){
        if( defined( $addr2 ) ){
	    $addr1 .= $addr2 =~ /^\d+$/ ? "..$addr2" : "...$addr2";
        } else {
	    $addr1 .= ' == $.' if $addr1 =~ /^\d+$/;
	}
	$cond = $negated ? "unless( $addr1 )\n" : "if( $addr1 )\n";
    }

    if( $opcode eq '' ){
	$Code .= "$cond$arg\n";

    } elsif( $opcode =~ s/-X-/$arg/e ){
	$Code .= "$cond$opcode\n";

    } elsif( $opcode =~ /TheEnd/ ){
	safeHere( \$opcode, \$arg );
	$Code .= "$cond$opcode$arg";

    } else {
	$Code .= "$cond$opcode\n";
    }
    0;
}

# Write (w command, w flag): store pathname
#
sub Write($$$$$$){
    my( $addr1, $addr2, $negated, $opcode, $path, $fl ) = @_;
    $wFiles{$path} = '';
    Emit( $addr1, $addr2, $negated, $opcode, $path, $fl );
}


# Label (: command): label definition
#
sub Label($$$$$$){
    my( $addr1, $addr2, $negated, $opcode, $lab, $fl ) = @_;
    my $rc = 0;
    $lab =~ s/\s+//;
    if( length( $lab ) ){
	my $h;
	if( ! exists( $Label{$lab} ) ){
	    $h = $Label{$lab}{name} = newLabel();
        } else {
	    $h = $Label{$lab}{name};
	    if( exists( $Label{$lab}{defined} ) ){
		my $dl = $Label{$lab}{defined};
		Warn( "duplicate label $lab (first defined at $dl)", $fl );
		$rc = 1;
	    }
	}
        $Label{$lab}{defined} = $fl;
	$Code .= "$h:;\n";
    }
    $rc;
}

# BeginBlock ({ command): push block start
#
sub BeginBlock($$$$$$){
    my( $addr1, $addr2, $negated, $opcode, $arg, $fl ) = @_;
    push( @BlockStack, [ $fl, $addr1, $addr2, $negated ] );
    Emit( $addr1, $addr2, $negated, $opcode, $arg, $fl );
}

# EndBlock (} command): check proper nesting
#
sub EndBlock($$$$$$){
    my( $addr1, $addr2, $negated, $opcode, $arg, $fl ) = @_;
    my $rc;
    my $jcom = pop( @BlockStack );
    if( defined( $jcom ) ){
	$rc = Emit( $addr1, $addr2, $negated, $opcode, $arg, $fl );
    } else {
	Warn( "unexpected '}'", $fl );
	$rc = 1;
    }
    $rc;
}

# Branch (t, b commands): check or create label, substitute default
#
sub Branch($$$$$$){
    my( $addr1, $addr2, $negated, $opcode, $lab, $fl ) = @_;
    $lab =~ s/\s+//; # no spaces at end
    my $h;
    if( length( $lab ) ){
	if( ! exists( $Label{$lab} ) ){
	    $h = $Label{$lab}{name} = newLabel();
        } else {
	    $h = $Label{$lab}{name};
	}
	push( @{$Label{$lab}{used}}, $fl );
    } else {
	$h = 'EOS';
    }
    $opcode =~ s/XXX/$h/e;
    Emit( $addr1, $addr2, $negated, $opcode, '', $fl );
}

# Change (c command): is special due to range end watching
#
sub Change($$$$$$){
    my( $addr1, $addr2, $negated, $opcode, $arg, $fl ) = @_;
    my $kwd = $negated ? 'unless' : 'if';
    if( defined( $addr2 ) ){
        $addr1 .= $addr2 =~ /^\d+$/ ? "..$addr2" : "...$addr2";
	if( ! $negated ){
	    $addr1  = '$icnt = ('.$addr1.')';
	    $opcode = 'if( $icnt =~ /E0$/ )' . $opcode;
	}
    } else {
	$addr1 .= ' == $.' if $addr1 =~ /^\d+$/;
    }
    safeHere( \$opcode, \$arg );
    $Code .= "$kwd( $addr1 ){\n  $opcode$arg}\n";
    0;
}


# Comment (# command): A no-op. Who would've thought that!
#
sub Comment($$$$$$){
    my( $addr1, $addr2, $negated, $opcode, $arg, $fl ) = @_;
### $Code .= "# $arg\n";
    0;
}

# stripRegex from the current command. If we're in the first
# part of s///, trailing spaces have to be kept as the initial
# part of the replacement string.
#
sub stripRegex($$;$){
    my( $del, $sref, $sub ) = @_;
    my $regex = $del;
    print "stripRegex:$del:$$sref:\n" if $useDEBUG;
    while( $$sref =~ s{^(.*?)(\\*)\Q$del\E(\s*)}{}s ){
        my $sl = $2;
	$regex .= $1.$sl.$del;
	if( length( $sl ) % 2 == 0 ){
            if( $sub && (length( $3 ) > 0) ){
                $$sref = $3 . $$sref;
	    }
	    return $regex;
	}
	$regex .= $3;
    }
    undef();
}

# stripTrans: take a <del> terminated string from y command
#   honoring and cleaning up of \-escaped <del>'s
#
sub stripTrans($$){
    my( $del, $sref ) = @_;
    my $t = '';
    print "stripTrans:$del:$$sref:\n" if $useDEBUG;
    while( $$sref =~ s{^(.*?)(\\*)\Q$del\E}{}s ){
        my $sl = $2;
	$t .= $1;
	if( length( $sl ) % 2 == 0 ){
	    $t .= $sl;
	    $t =~ s/\\\\/\\/g;
	    return $t;
	}
	chop( $sl );
	$t .= $sl.$del.$3;
    }
    undef();
}

# makey - construct Perl y/// from sed y///
#
sub makey($$$){
    my( $fr, $to, $fl ) = @_;
    my $error = 0;

    # Ensure that any '-' is up front.
    # Diagnose duplicate contradicting mappings
    my %tr;
    for( my $i = 0; $i < length($fr); $i++ ){
	my $fc = substr($fr,$i,1);
	my $tc = substr($to,$i,1);
	if( exists( $tr{$fc} ) && $tr{$fc} ne $tc ){
	    Warn( "ambiguous translation for character '$fc' in 'y' command",
		  $fl );
	    $error++;
	}
	$tr{$fc} = $tc;
    }
    $fr = $to = '';
    if( exists( $tr{'-'} ) ){
	( $fr, $to ) = ( '-', $tr{'-'} );
	delete( $tr{'-'} );
    } else {
	$fr = $to = '';
    }
    # might just as well sort it...
    for my $fc ( sort keys( %tr ) ){
	$fr .= $fc;
	$to .= $tr{$fc};
    }
    # make embedded delimiters and newlines safe
    $fr =~ s/([{}])/\$1/g;
    $to =~ s/([{}])/\$1/g;
    $fr =~ s/\n/\\n/g;
    $to =~ s/\n/\\n/g;
    return $error ? undef() : "{ y{$fr}{$to}; }";
}

######
# makes - construct Perl s/// from sed s///
#
sub makes($$$$$$$){
    my( $regex, $subst, $path, $global, $print, $nmatch, $fl ) = @_;

    # make embedded newlines safe
    $regex =~ s/\n/\\n/g;
    $subst =~ s/\n/\\n/g;
 
    my $code;
    # n-th occurrence
    #
    if( length( $nmatch ) ){
	$code = <<TheEnd;
{ \$n = $nmatch;
  while( --\$n && ( \$s = m ${regex}g ) ){}
  \$s = ( substr( \$_, pos() ) =~ s ${regex}${subst}s ) if \$s;
  \$CondReg ||= \$s;
TheEnd
    } else {
        $code = <<TheEnd;
{ \$s = s ${regex}${subst}s${global};
  \$CondReg ||= \$s;
TheEnd
    }
    if( $print ){
        $code .= '  print $_, "\n" if $s;'."\n";
    }
    if( defined( $path ) ){
        $wFiles{$path} = '';
	$code .= " _w( '$path' ) if \$s;\n";
        $GenKey{'w'} = 1;
    }
    $code .= "}";
}

=head1 BASIC REGULAR EXPRESSIONS

A I<Basic Regular Expression> (BRE), as defined in POSIX 1003.2, consists
of I<atoms>, for matching parts of a string, and I<bounds>, specifying
repetitions of a preceding atom.

=head2 Atoms

The possible atoms of a BRE are: B<.>, matching any single character;
B<^> and B<$>, matching the null string at the beginning or end
of a string, respectively; a I<bracket expressions>, enclosed
in B<[> and B<]> (see below); and any single character with no
other significance (matching that character). A B<\> before one
of: B<.>, B<^>, B<$>, B<[>, B<*>, B<\>, matching the character
after the backslash. A sequence of atoms enclosed in B<\(> and B<\)>
becomes an atom and establishes the target for a I<backreference>,
consisting of the substring that actually matches the enclosed atoms.
Finally, B<\> followed by one of the digits B<0> through B<9> is a
backreference.

A B<^> that is not first, or a B<$> that is not last does not have
a special significance and need not be preceded by a backslash to
become literal. The same is true for a B<]>, that does not terminate
a bracket expression.

An unescaped backslash cannot be last in a BRE.

=head2 Bounds

The BRE bounds are: B<*>, specifying 0 or more matches of the preceding
atom; B<\{>I<count>B<\}>, specifying that many repetitions;
B<\{>I<minimum>B<,\}>, giving a lower limit; and
B<\{>I<minimum>B<,>I<maximum>B<\}> finally defines a lower and upper
bound. 

A bound appearing as the first item in a BRE is taken literally.

=head2 Bracket Expressions

A I<bracket expression> is a list of characters, character ranges
and character classes enclosed in B<[> and B<]> and matches any
single character from the represented set of characters.

A character range is written as two characters separated by B<-> and
represents all characters (according to the character collating sequence)
that are not less than the first and not greater than the second.
(Ranges are very collating-sequence-dependent, and portable programs
should avoid relying on them.)

A character class is one of the class names

   alnum     digit     punct
   alpha     graph     space
   blank     lower     upper
   cntrl     print     xdigit

enclosed in B<[:> and B<:]> and represents the set of characters
as defined in ctype(3).

If the first character after B<[> is B<^>, the sense of matching is
inverted.

To include a literal 'C<^>', place it anywhere else but first. To
include a literal 'C<]>' place it first or immediately after an
initial B<^>. To include a literal 'C<->' make it the first (or
second after B<^>) or last character, or the second endpoint of
a range.

The special bracket expression constructs C<[[:E<lt>:]]> and C<[[:E<gt>:]]> 
match the null string at the beginning and end of a word respectively.
(Note that neither is identical to Perl's '\b' atom.)

=head2 Additional Atoms

Since some sed implementations provide additional regular expression
atoms (not defined in POSIX 1003.2), B<psed> is capable of translating
the following backslash escapes:

=over 4

=item B<\E<lt>> This is the same as C<[[:E<gt>:]]>.

=item B<\E<gt>> This is the same as C<[[:E<lt>:]]>.

=item B<\w> This is an abbreviation for C<[[:alnum:]_]>.

=item B<\W> This is an abbreviation for C<[^[:alnum:]_]>.

=item B<\y> Match the empty string at a word boundary.

=item B<\B> Match the empty string between any two either word or non-word characters.

=back

To enable this feature, the environment variable PSEDEXTBRE must be set
to a string containing the requested characters, e.g.:
C<PSEDEXTBRE='E<lt>E<gt>wW'>.

=cut

#####
# bre2p - convert BRE to Perl RE
#
sub peek(\$$){
    my( $pref, $ic ) = @_;
    $ic < length($$pref)-1 ? substr( $$pref, $ic+1, 1 ) : '';
}

sub bre2p($$$){
    my( $del, $pat, $fl ) = @_;
    my $led = $del;
    $led =~ tr/{([</})]>/;
    $led = '' if $led eq $del;

    $pat = substr( $pat, 1, length($pat) - 2 );
    my $res = '';
    my $bracklev = 0;
    my $backref  = 0;
    my $parlev = 0;
    for( my $ic = 0; $ic < length( $pat ); $ic++ ){
        my $c = substr( $pat, $ic, 1 );
        if( $c eq '\\' ){
	    ### backslash escapes
            my $nc = peek($pat,$ic);
            if( $nc eq '' ){
                Warn( "'\\' cannot be last in pattern", $fl );
                return undef();
            }
	    $ic++;
            if( $nc eq $del ){ ## \<pattern del> => \<pattern del>
                $res .= "\\$del";

	    } elsif( $nc =~ /([[.*\\n])/ ){
		## check for \-escaped magics and \n:
		## \[ \. \* \\ \n stay as they are
                $res .= '\\'.$nc;

            } elsif( $nc eq '(' ){ ## \( => (
                $parlev++;
                $res .= '(';

            } elsif( $nc eq ')' ){ ## \) => )
                $parlev--;
		$backref++;
                if( $parlev < 0 ){
                    Warn( "unmatched '\\)'", $fl );
                    return undef();
                }
                $res .= ')';

            } elsif( $nc eq '{' ){ ## repetition factor \{<i>[,[<j>]]\}
                my $endpos = index( $pat, '\\}', $ic );
                if( $endpos < 0 ){
                    Warn( "unmatched '\\{'", $fl );
                    return undef();
                }
                my $rep = substr( $pat, $ic+1, $endpos-($ic+1) );
                $ic = $endpos + 1;

  	        if( $res =~ /^\^?$/ ){
		    $res .= "\\{$rep\}";
                } elsif( $rep =~ /^(\d+)(,?)(\d*)?$/ ){
                    my $min = $1;
                    my $com = $2 || '';
                    my $max = $3;
                    if( length( $max ) ){
                        if( $max < $min ){
                            Warn( "maximum less than minimum in '\\{$rep\\}'",
				  $fl );
                            return undef();
                        }
                    } else {
                        $max = '';
                    }
		    # simplify some
		    if( $min == 0 && $max eq '1' ){
			$res .= '?';
		    } elsif( $min == 1 && "$com$max" eq ',' ){
			$res .= '+';
		    } elsif( $min == 0 && "$com$max" eq ',' ){
			$res .= '*';
		    } else {
			$res .= "{$min$com$max}";
		    }
                } else {
                    Warn( "invalid repeat clause '\\{$rep\\}'", $fl );
                    return undef();
                }

            } elsif( $nc =~ /^[1-9]$/ ){
		## \1 .. \9 => \1 .. \9, but check for a following digit
		if( $nc > $backref ){
                    Warn( "invalid backreference ($nc)", $fl );
                    return undef();
		}
                $res .= "\\$nc";
		if( peek($pat,$ic) =~ /[0-9]/ ){
		    $res .= '(?:)';
		}

            } elsif( $useEXTBRE && ( $nc =~ /[$useEXTBRE]/ ) ){
		## extensions - at most <>wWyB - not in POSIX
                if(      $nc eq '<' ){ ## \< => \b(?=\w), be precise
                    $res .= '\\b(?<=\\W)';
                } elsif( $nc eq '>' ){ ## \> => \b(?=\W), be precise
                    $res .= '\\b(?=\\W)';
                } elsif( $nc eq 'y' ){ ## \y => \b
                    $res .= '\\b';
                } else {               ## \B, \w, \W remain the same
                    $res .= "\\$nc";
                } 
	    } elsif( $nc eq $led ){
		## \<closing bracketing-delimiter> - keep '\'
		$res .= "\\$nc";

            } else { ## \ <char> => <char> ("as if '\' were not present")
                $res .= $nc;
            }

        } elsif( $c eq '.' ){ ## . => .
            $res .= $c;

	} elsif( $c eq '*' ){ ## * => * but \* if there's nothing preceding it
	    if( $res =~ /^\^?$/ ){
                $res .= '\\*';
            } elsif( substr( $res, -1, 1 ) ne '*' ){
		$res .= $c;
	    }

        } elsif( $c eq '[' ){
	    ## parse []: [^...] [^]...] [-...]
	    my $add = '[';
	    if( peek($pat,$ic) eq '^' ){
		$ic++;
		$add .= '^';
	    }
	    my $nc = peek($pat,$ic);
  	    if( $nc eq ']' || $nc eq '-' ){
		$add .= $nc;
                $ic++;
	    }
	    # check that [ is not trailing
	    if( $ic >= length( $pat ) - 1 ){
		Warn( "unmatched '['", $fl );
		return undef();
	    }
	    # look for [:...:] and x-y
	    my $rstr = substr( $pat, $ic+1 );
	    if( $rstr =~ /^((?:\[:\(\w+|[><]\):\]|[^]-](?:-[^]])?)*)/ ){
 	        my $cnt = $1;
		$ic += length( $cnt );
		$cnt =~ s/([\\\$])/\\$1/g; # '\', '$' are magic in Perl []
		# try some simplifications
 	        my $red = $cnt;
		if( $red =~ s/0-9// ){
		    $cnt = $red.'\d';
		    if( $red =~ s/A-Z// && $red =~ s/a-z// && $red =~ s/_// ){
			$cnt = $red.'\w';
                    }
		}
		$add .= $cnt;

		# POSIX 1003.2 has this (optional) for begin/end word
		$add = '\\b(?=\\W)'  if $add eq '[[:<:]]';
		$add = '\\b(?<=\\W)' if $add eq '[[:>:]]';

	    }

	    ## may have a trailing '-' before ']'
	    if( $ic < length($pat) - 1 &&
                substr( $pat, $ic+1 ) =~ /^(-?])/ ){
		$ic += length( $1 );
		$add .= $1;
		# another simplification
		$add =~ s/^\[(\^?)(\\[dw])]$/ $1 eq '^' ? uc($2) : $2 /e;
		$res .= $add;
	    } else {
		Warn( "unmatched '['", $fl );
		return undef();
	    }

        } elsif( $c eq $led ){ ## unescaped <closing bracketing-delimiter>
            $res .= "\\$c";

        } elsif( $c eq ']' ){ ## unmatched ] is not magic
            $res .= ']';

        } elsif( $c =~ /[|+?{}()]/ ){ ## not magic in BRE, but in Perl: \-quote
            $res .= "\\$c";

        } elsif( $c eq '^' ){ ## not magic unless 1st, but in Perl: \-quote
            $res .= length( $res ) ? '\\^' : '^';

        } elsif( $c eq '$' ){ ## not magic unless last, but in Perl: \-quote
            $res .= $ic == length( $pat ) - 1 ? '$' : '\\$';

        } else {
            $res .= $c;
        }
    }

    if( $parlev ){
       Warn( "unmatched '\\('", $fl );
       return undef();
    }

    # final cleanup: eliminate raw HTs
    $res =~ s/\t/\\t/g;
    return $del . $res . ( $led ? $led : $del );
}


#####
# sub2p - convert sed substitution to Perl substitution
#
sub sub2p($$$){
    my( $del, $subst, $fl ) = @_;
    my $led = $del;
    $led =~ tr/{([</})]>/;
    $led = '' if $led eq $del;

    $subst = substr( $subst, 1, length($subst) - 2 );
    my $res = '';
 
    for( my $ic = 0; $ic < length( $subst ); $ic++ ){
        my $c = substr( $subst, $ic, 1 );
        if( $c eq '\\' ){
	    ### backslash escapes
            my $nc = peek($subst,$ic);
            if( $nc eq '' ){
                Warn( "'\\' cannot be last in substitution", $fl );
                return undef();
            }
	    $ic++;
	    if( $nc =~ /[\\$del$led]/ ){ ## \ and delimiter
		$res .= '\\' . $nc;
            } elsif( $nc =~ /[1-9]/ ){ ## \1 - \9 => ${1} - ${9}
                $res .= '${' . $nc . '}';
	    } else { ## everything else (includes &): omit \
		$res .= $nc;
	    }
        } elsif( $c eq '&' ){ ## & => $&
            $res .= '$&';
	} elsif( $c =~ /[\$\@$led]/ ){ ## magic in Perl's substitution string
	    $res .= '\\' . $c;
        } else {
	    $res .= $c;
	}
    }

    # final cleanup: eliminate raw HTs
    $res =~ s/\t/\\t/g;
    return ( $led ? $del : $led ) . $res . ( $led ? $led : $del );
}


sub Parse(){
    my $error = 0;
    my( $pdef, $pfil, $plin );
    for( my $icom = 0; $icom < @Commands; $icom++ ){
	my $cmd = $Commands[$icom];
	print "Parse:$cmd:\n" if $useDEBUG;
	$cmd =~ s/^\s+//;
	next unless length( $cmd );
	my $scom = $icom;
	if( exists( $Defined{$icom} ) ){
	    $pdef = $Defined{$icom};
	    if( $pdef =~ /^ #(\d+)/ ){
		$pfil = 'expression #';
		$plin = $1;
	    } else {
		$pfil = "$pdef l.";
		$plin = 1;
            }
        } else {
	    $plin++;
        }
        my $fl = "$pfil$plin";

        # insert command as comment in gnerated code
	#
	$Code .= "# $cmd\n" if $doGenerate;

	# The Address(es)
	#
	my( $negated, $naddr, $addr1, $addr2 );
	$naddr = 0;
	if(      $cmd =~ s/^(\d+)\s*// ){
	    $addr1 = "$1"; $naddr++;
	} elsif( $cmd =~ s/^\$\s*// ){
	    $addr1 = 'eofARGV()'; $naddr++;
	} elsif( $cmd =~ s{^(/)}{} || $cmd =~ s{^\\(.)}{} ){
	    my $del = $1;
	    my $regex = stripRegex( $del, \$cmd );
	    if( defined( $regex ) ){
		$addr1 = 'm '.bre2p( $del, $regex, $fl ).'s';
		$naddr++;
	    } else {
		Warn( "malformed regex, 1st address", $fl );
		$error++;
		next;
	    }
        }
        if( defined( $addr1 ) && $cmd =~ s/,\s*// ){
 	    if(      $cmd =~ s/^(\d+)\s*// ){
	        $addr2 = "$1"; $naddr++;
	    } elsif( $cmd =~ s/^\$\s*// ){
	        $addr2 = 'eofARGV()'; $naddr++;
	    } elsif( $cmd =~ s{^(/)}{} || $cmd =~ s{^\\(.)}{} ){
		my $del = $1;
	        my $regex = stripRegex( $del, \$cmd );
		if( defined( $regex ) ){
		    $addr2 = 'm '. bre2p( $del, $regex, $fl ).'s';
		    $naddr++;
		} else {
		    Warn( "malformed regex, 2nd address", $fl );
		    $error++;
		    next;
		}
            } else {
		Warn( "invalid address after ','", $fl );
		$error++;
		next;
            }
        }

        # address modifier '!'
        #
        $negated = $cmd =~ s/^!\s*//;
	if( defined( $addr1 ) ){
	    print "Parse: addr1=$addr1" if $useDEBUG;
	    if( defined( $addr2 ) ){
		print ", addr2=$addr2 " if $useDEBUG;
		# both numeric and addr1 > addr2 => eliminate addr2
		undef( $addr2 ) if $addr1 =~ /^\d+$/ &&
                                   $addr2 =~ /^\d+$/ && $addr1 > $addr2;
	    }
	}
	print 'negated' if $useDEBUG && $negated;
	print " command:$cmd\n" if $useDEBUG;

	# The Command
	#
        if( $cmd !~ s/^([:#={}abcdDgGhHilnNpPqrstwxy])\s*// ){
	    my $h = substr( $cmd, 0, 1 );
 	    Warn( "unknown command '$h'", $fl );
	    $error++;
	    next;
	}
        my $key = $1;

	my $tabref = $ComTab{$key};
	$GenKey{$key} = 1;
	if( $naddr > $tabref->[0] ){
	    Warn( "excess address(es)", $fl );
	    $error++;
	    next;
	}

	my $arg = '';
	if(      $tabref->[1] eq 'str' ){
	    # take remainder - don't care if it is empty
	    $arg = $cmd;
            $cmd = '';

	} elsif( $tabref->[1] eq 'txt' ){
	    # multi-line text
	    my $goon = $cmd =~ /(.*)\\$/;
	    if( length( $1 ) ){
		Warn( "extra characters after command ($cmd)", $fl );
		$error++;
	    }
	    while( $goon ){
		$icom++;
		if( $icom > $#Commands ){
		    Warn( "unexpected end of script", $fl );
		    $error++;
		    last;
		}
		$cmd = $Commands[$icom];
		$Code .= "# $cmd\n" if $doGenerate;
		$goon = $cmd =~ s/\\$//;
		$cmd =~ s/\\(.)/$1/g;
		$arg .= "\n" if length( $arg );
		$arg .= $cmd;
	    }
	    $arg .= "\n" if length( $arg );
	    $cmd = '';

	} elsif( $tabref->[1] eq 'sub' ){
	    # s///
	    if( ! length( $cmd ) ){
		Warn( "'s' command requires argument", $fl );
		$error++;
		next;
	    }
	    if( $cmd =~ s{^([^\\\n])}{} ){
		my $del = $1;
		my $regex = stripRegex( $del, \$cmd, "s" );
		if( ! defined( $regex ) ){
		    Warn( "malformed regular expression", $fl );
		    $error++;
		    next;
		}
		$regex = bre2p( $del, $regex, $fl );

		# a trailing \ indicates embedded NL (in replacement string)
		while( $cmd =~ s/(?<!\\)\\$/\n/ ){
		    $icom++;
		    if( $icom > $#Commands ){
			Warn( "unexpected end of script", $fl );
			$error++;
			last;
		    }
		    $cmd .= $Commands[$icom];
	            $Code .= "# $Commands[$icom]\n" if $doGenerate;
		}

		my $subst = stripRegex( $del, \$cmd );
		if( ! defined( $regex ) ){
		    Warn( "malformed substitution expression", $fl );
		    $error++;
		    next;
		}
		$subst = sub2p( $del, $subst, $fl );

		# parse s/// modifier: g|p|0-9|w <file>
		my( $global, $nmatch, $print, $write ) =
		  ( '',      '',      0,      undef );
		while( $cmd =~ s/^([gp0-9])// ){
		    $1 eq 'g' ? ( $global = 'g' ) :
  		    $1 eq 'p' ? ( $print  = $1  ) : ( $nmatch .= $1 );
                }
		$write = $1 if $cmd =~ s/w\s*(.*)$//;
  	        ### $nmatch =~ s/^(\d)\1*$/$1/; ### may be dangerous?
		if( $global && length( $nmatch ) || length( $nmatch ) > 1 ){
		    Warn( "conflicting flags '$global$nmatch'", $fl );
		    $error++;
		    next;
		}

		$arg = makes( $regex, $subst,
			      $write, $global, $print, $nmatch, $fl );
		if( ! defined( $arg ) ){
		    $error++;
		    next;
		}

            } else {
		Warn( "improper delimiter in s command", $fl );
		$error++;
		next;
            }

	} elsif( $tabref->[1] eq 'tra' ){
	    # y///
	    # a trailing \ indicates embedded newline
	    while( $cmd =~ s/(?<!\\)\\$/\n/ ){
		$icom++;
		if( $icom > $#Commands ){
		    Warn( "unexpected end of script", $fl );
		    $error++;
		    last;
		}
		$cmd .= $Commands[$icom];
                $Code .= "# $Commands[$icom]\n" if $doGenerate;
	    }
	    if( ! length( $cmd ) ){
		Warn( "'y' command requires argument", $fl );
		$error++;
		next;
	    }
	    my $d = substr( $cmd, 0, 1 ); $cmd = substr( $cmd, 1 );
	    if( $d eq '\\' ){
		Warn( "'\\' not valid as delimiter in 'y' command", $fl );
		$error++;
		next;
	    }
	    my $fr = stripTrans( $d, \$cmd );
	    if( ! defined( $fr ) || ! length( $cmd ) ){
		Warn( "malformed 'y' command argument", $fl );
		$error++;
		next;
	    }
	    my $to = stripTrans( $d, \$cmd );
	    if( ! defined( $to ) ){
		Warn( "malformed 'y' command argument", $fl );
		$error++;
		next;
	    }
	    if( length($fr) != length($to) ){
		Warn( "string lengths in 'y' command differ", $fl );
		$error++;
		next;
	    }
	    if( ! defined( $arg = makey( $fr, $to, $fl ) ) ){
		$error++;
		next;
	    }

	}

	# $cmd must be now empty - exception is {
	if( $cmd !~ /^\s*$/ ){
	    if( $key eq '{' ){
		# dirty hack to process command on '{' line
		$Commands[$icom--] = $cmd;
	    } else {
		Warn( "extra characters after command ($cmd)", $fl );
		$error++;
		next;
	    }
	}

	# Make Code
        #
	if( &{$tabref->[2]}( $addr1, $addr2, $negated,
                             $tabref->[3], $arg, $fl ) ){
	    $error++;
	}
    }

    while( @BlockStack ){
	my $bl = pop( @BlockStack );
	Warn( "start of unterminated '{'", $bl );
        $error++;
    }

    for my $lab ( keys( %Label ) ){
	if( ! exists( $Label{$lab}{defined} ) ){
	    for my $used ( @{$Label{$lab}{used}} ){
 	        Warn( "undefined label '$lab'", $used );
	        $error++;
	    }
	}
    }

    exit( 1 ) if $error;
}


##############
#### MAIN ####
##############

sub usage(){
    print STDERR "Usage: sed [-an] command [file...]\n";
    print STDERR "           [-an] [-e command] [-f script-file] [file...]\n";
}

###################
# Here we go again...
#
my $expr = 0;
while( @ARGV && $ARGV[0] =~ /^-(.)(.*)$/ ){
    my $opt = $1;
    my $arg = $2;
    shift( @ARGV );
    if(      $opt eq 'e' ){
        if( length( $arg ) ){
	    push( @Commands, split( "\n", $arg ) );
        } elsif( @ARGV ){
	    push( @Commands, shift( @ARGV ) ); 
        } else {
            Warn( "option -e requires an argument" );
            usage();
            exit( 1 );
        }
	$expr++;
        $Defined{$#Commands} = " #$expr";
	next;
    }
    if( $opt eq 'f' ){
        my $path;
        if( length( $arg ) ){
	    $path = $arg;
        } elsif( @ARGV ){
	    $path = shift( @ARGV ); 
        } else {
            Warn( "option -f requires an argument" );
            usage();
            exit( 1 );
        }
	my $fst = $#Commands + 1;
        open( SCRIPT, "<$path" ) || die( "$0: $path: could not open ($!)\n" );
        my $cmd;
        while( defined( $cmd = <SCRIPT> ) ){
            chomp( $cmd );
            push( @Commands, $cmd );
        }
        close( SCRIPT );
	if( $#Commands >= $fst ){
	    $Defined{$fst} = "$path";
	}
	next;
    }
    if( $opt eq '-' && $arg eq '' ){
	last;
    }
    if( $opt eq 'h' || $opt eq '?' ){
        usage();
        exit( 0 );
    }
    if( $opt eq 'n' ){
	$doAutoPrint = 0;
    } elsif( $opt eq 'a' ){
	$doOpenWrite = 0;
    } else {
        Warn( "illegal option '$opt'" );
        usage();
        exit( 1 );
    }
    if( length( $arg ) ){
	unshift( @ARGV, "-$arg" );
    }
}

# A singleton command may be the 1st argument when there are no options.
#
if( @Commands == 0 ){
    if( @ARGV == 0 ){
        Warn( "no script command given" );
        usage();
        exit( 1 );
    }
    push( @Commands, split( "\n", shift( @ARGV ) ) );
    $Defined{0} = ' #1';
}

print STDERR "Files: @ARGV\n" if $useDEBUG;

# generate leading code
#
$Func = <<'[TheEnd]';

# openARGV: open 1st input file
#
sub openARGV(){
    unshift( @ARGV, '-' ) unless @ARGV;
    my $file = shift( @ARGV );
    open( ARG, "<$file" )
    || die( "$0: can't open $file for reading ($!)\n" );
    $isEOF = 0;
}

# getsARGV: Read another input line into argument (default: $_).
#           Move on to next input file, and reset EOF flag $isEOF.
sub getsARGV(;\$){
    my $argref = @_ ? shift() : \$_; 
    while( $isEOF || ! defined( $$argref = <ARG> ) ){
	close( ARG );
	return 0 unless @ARGV;
	my $file = shift( @ARGV );
	open( ARG, "<$file" )
	|| die( "$0: can't open $file for reading ($!)\n" );
	$isEOF = 0;
    }
    1;
}

# eofARGV: end-of-file test
#
sub eofARGV(){
    return @ARGV == 0 && ( $isEOF = eof( ARG ) );
}

# makeHandle: Generates another file handle for some file (given by its path)
#             to be written due to a w command or an s command's w flag.
sub makeHandle($){
    my( $path ) = @_;
    my $handle;
    if( ! exists( $wFiles{$path} ) || $wFiles{$path} eq '' ){
        $handle = $wFiles{$path} = gensym();
	if( $doOpenWrite ){
	    if( ! open( $handle, ">$path" ) ){
		die( "$0: can't open $path for writing: ($!)\n" );
	    }
	}
    } else {
        $handle = $wFiles{$path};
    }
    return $handle;
}

# printQ: Print queued output which is either a string or a reference
#         to a pathname.
sub printQ(){
    for my $q ( @Q ){
	if( ref( $q ) ){
            # flush open w files so that reading this file gets it all
	    if( exists( $wFiles{$$q} ) && $wFiles{$$q} ne '' ){
		open( $wFiles{$$q}, ">>$$q" );
	    }
            # copy file to stdout: slow, but safe
	    if( open( RF, "<$$q" ) ){
		while( defined( my $line = <RF> ) ){
		    print $line;
		}
		close( RF );
	    }
	} else {
	    print $q;
	}
    }
    undef( @Q );
}

[TheEnd]

# generate the sed loop
#
$Code .= <<'[TheEnd]';
sub openARGV();
sub getsARGV(;\$);
sub eofARGV();
sub printQ();

# Run: the sed loop reading input and applying the script
#
sub Run(){
    my( $h, $icnt, $s, $n );
    # hack (not unbreakable :-/) to avoid // matching an empty string
    my $z = "\000"; $z =~ /$z/;
    # Initialize.
    openARGV();
    $Hold    = '';
    $CondReg = 0;
    $doPrint = $doAutoPrint;
CYCLE:
    while( getsARGV() ){
	chomp();
	$CondReg = 0;   # cleared on t
BOS:;
[TheEnd]

    # parse - avoid opening files when doing s2p
    #
    ( $svOpenWrite, $doOpenWrite ) = (  $doOpenWrite, $svOpenWrite )
      if $doGenerate;
    Parse();
    ( $svOpenWrite, $doOpenWrite ) = (  $doOpenWrite, $svOpenWrite )
      if $doGenerate;

    # append trailing code
    #
    $Code .= <<'[TheEnd]';
EOS:    if( $doPrint ){
            print $_, "\n";
        } else {
	    $doPrint = $doAutoPrint;
	}
        printQ() if @Q;
    }

    exit( 0 );
}
[TheEnd]


# append optional functions, prepend prototypes
#
my $Proto = "# prototypes\n";
if( $GenKey{'l'} ){
    $Proto .= "sub _l();\n";
    $Func .= <<'[TheEnd]';
# _l: l command processing
#
sub _l(){        
    my $h = $_;
    my $mcpl = 70;
    # transform non printing chars into escape notation
    $h =~ s/\\/\\\\/g;
    if( $h =~ /[^[:print:]]/ ){
	$h =~ s/\a/\\a/g;
	$h =~ s/\f/\\f/g;
	$h =~ s/\n/\\n/g;
	$h =~ s/\t/\\t/g;
	$h =~ s/\r/\\r/g;
	$h =~ s/\e/\\e/g;
        $h =~ s/([^[:print:]])/sprintf("\\%03o", ord($1))/ge;
    }
    # split into lines of length $mcpl
    while( length( $h ) > $mcpl ){
	my $l = substr( $h, 0, $mcpl-1 );
	$h = substr( $h, $mcpl );
	# remove incomplete \-escape from end of line
	if( $l =~ s/(?<!\\)(\\[0-7]{0,2})$// ){
	    $h = $1 . $h;
	}
	print $l, "\\\n";
    }
    print "$h\$\n";
}

[TheEnd]
}

if( $GenKey{'r'} ){
    $Proto .= "sub _r(\$);\n";
    $Func .= <<'[TheEnd]';
# _r: r command processing: Save a reference to the pathname.
#
sub _r($){
    my $path = shift();
    push( @Q, \$path );
}

[TheEnd]
}

if( $GenKey{'t'} ){
    $Proto .= "sub _t();\n";
    $Func .= <<'[TheEnd]';
# _t: t command - condition register test/reset
#
sub _t(){
    my $res = $CondReg;
    $CondReg = 0;
    $res;
}

[TheEnd]
}

if( $GenKey{'w'} ){
    $Proto .= "sub _w(\$);\n";
    $Func .= <<'[TheEnd]';
# _w: w command and s command's w flag - write to file 
#
sub _w($){
    my $path   = shift();
    my $handle = $wFiles{$path};
    if( ! $doOpenWrite && ! defined( fileno( $handle ) ) ){
	open( $handle, ">$path" )
	|| die( "$0: $path: cannot open ($!)\n" );
    }
    print $handle $_, "\n";
}

[TheEnd]
}

$Code = $Proto . $Code;

# magic "#n" - same as -n option
#
$doAutoPrint = 0 if substr( $Commands[0], 0, 2 ) eq '#n';

# eval code - check for errors
#
print "Code:\n$Code$Func" if $useDEBUG;
eval $Code . $Func;
if( $@ ){
    print "Code:\n$Code$Func";
    die( "$0: internal error - generated incorrect Perl code: $@\n" );
}

if( $doGenerate ){

    # write full Perl program
    #
 
    # bang line, declarations, prototypes
    print <<TheEnd;
#!$perlpath -w
eval 'exec $perlpath -S \$0 \${1+"\$@"}'
  if 0;
\$0 =~ s/^.*?(\\w+)\[\\.\\w+\]*\$/\$1/;

use strict;
use Symbol;
use vars qw{ \$isEOF \$Hold \%wFiles \@Q \$CondReg
	     \$doAutoPrint \$doOpenWrite \$doPrint };
\$doAutoPrint = $doAutoPrint;
\$doOpenWrite = $doOpenWrite;
TheEnd

    my $wf = "'" . join( "', '",  keys( %wFiles ) ) . "'";
    if( $wf ne "''" ){
	print <<TheEnd;
sub makeHandle(\$);
for my \$p ( $wf ){
   exit( 1 ) unless makeHandle( \$p );
}
TheEnd
   }

   print $Code;
   print "Run();\n";
   print $Func;
   exit( 0 );

} else {

    # execute: make handles (and optionally open) all w files; run!
    for my $p ( keys( %wFiles ) ){
        exit( 1 ) unless makeHandle( $p );
    }
    Run();
}


=head1 ENVIRONMENT

The environment variable C<PSEDEXTBRE> may be set to extend BREs.
See L<"Additional Atoms">.

=head1 DIAGNOSTICS

=over 4

=item ambiguous translation for character '%s' in 'y' command

The indicated character appears twice, with different translations.

=item '[' cannot be last in pattern

A '[' in a BRE indicates the beginning of a I<bracket expression>.

=item '\' cannot be last in pattern

A '\' in a BRE is used to make the subsequent character literal.

=item '\' cannot be last in substitution

A '\' in a substitution string is used to make the subsequent character literal.

=item conflicting flags '%s'

In an B<s> command, either the 'g' flag and an n-th occurrence flag, or
multiple n-th occurrence flags are specified. Note that only the digits
^'1' through '9' are permitted.

=item duplicate label %s (first defined at %s)

=item excess address(es)

The command has more than the permitted number of addresses.

=item extra characters after command (%s)

=item illegal option '%s'

=item improper delimiter in s command

The BRE and substitution may not be delimited with '\' or newline.

=item invalid address after ','

=item invalid backreference (%s)

The specified backreference number exceeds the number of backreferences
in the BRE.

=item invalid repeat clause '\{%s\}'

The repeat clause does not contain a valid integer value, or pair of
values.

=item malformed regex, 1st address

=item malformed regex, 2nd address

=item malformed regular expression

=item malformed substitution expression

=item malformed 'y' command argument

The first or second string of a B<y> command  is syntactically incorrect.

=item maximum less than minimum in '\{%s\}'

=item no script command given

There must be at least one B<-e> or one B<-f> option specifying a
script or script file.

=item '\' not valid as delimiter in 'y' command

=item option -e requires an argument

=item option -f requires an argument

=item 's' command requires argument

=item start of unterminated '{'

=item string lengths in 'y' command differ

The translation table strings in a B<y> command must have equal lengths.

=item undefined label '%s'

=item unexpected '}'

A B<}> command without a preceding B<{> command was encountered.

=item unexpected end of script

The end of the script was reached although a text line after a
B<a>, B<c> or B<i> command indicated another line.

=item unknown command '%s'

=item unterminated '['

A BRE contains an unterminated bracket expression.

=item unterminated '\('

A BRE contains an unterminated backreference.

=item '\{' without closing '\}'

A BRE contains an unterminated bounds specification.

=item '\)' without preceding '\('

=item 'y' command requires argument

=back

=head1 EXAMPLE

The basic material for the preceding section was generated by running
the sed script

   #no autoprint
   s/^.*Warn( *"\([^"]*\)".*$/\1/
   t process
   b
   :process
   s/$!/%s/g
   s/$[_[:alnum:]]\{1,\}/%s/g
   s/\\\\/\\/g
   s/^/=item /
   p

on the program's own text, and piping the output into C<sort -u>.


=head1 SED SCRIPT TRANSLATION

If this program is invoked with the name F<s2p> it will act as a
sed-to-Perl translator. After option processing (all other
arguments are ignored), a Perl program is printed on standard
output, which will process the input stream (as read from all
arguments) in the way defined by the sed script and the option setting
used for the translation.

=head1 SEE ALSO

perl(1), re_format(7)

=head1 BUGS

The B<l> command will show escape characters (ESC) as 'C<\e>', but
a vertical tab (VT) in octal.

Trailing spaces are truncated from labels in B<:>, B<t> and B<b> commands.

The meaning of an empty regular expression ('C<//>'), as defined by B<sed>,
is "the last pattern used, at run time". This deviates from the Perl
interpretation, which will re-use the "last last successfully executed
regular expression". Since keeping track of pattern usage would create
terribly cluttered code, and differences would only appear in obscure
context (where other B<sed> implementations appear to deviate, too),
the Perl semantics was adopted. Note that common usage of this feature,
such as in C</abc/s//xyz/>, will work as expected.

Collating elements (of bracket expressions in BREs) are not implemented.

=head1 STANDARDS

This B<sed> implementation conforms to the IEEE Std1003.2-1992 ("POSIX.2")
definition of B<sed>, and is compatible with the I<OpenBSD>
implementation, except where otherwise noted (see L<"BUGS">).

=head1 AUTHOR

This Perl implementation of I<sed> was written by Wolfgang Laun,
I<Wolfgang.Laun@alcatel.at>.

=head1 COPYRIGHT and LICENSE

This program is free and open software. You may use, modify,
distribute, and sell this program (and any modified variants) in any
way you wish, provided you do not restrict others from doing the same.

=cut


__END__
:endofperl
