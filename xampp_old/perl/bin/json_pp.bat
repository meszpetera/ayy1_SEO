@rem = '--*-Perl-*--
@echo off
if "%OS%" == "Windows_NT" goto WinNT
IF EXIST "%~dp0perl.exe" (
"%~dp0perl.exe" -x -S "%0" %1 %2 %3 %4 %5 %6 %7 %8 %9
) ELSE IF EXIST "%~dp0..\..\bin\perl.exe" (
"%~dp0..\..\bin\perl.exe" -x -S "%0" %1 %2 %3 %4 %5 %6 %7 %8 %9
) ELSE (
perl -x -S "%0" %1 %2 %3 %4 %5 %6 %7 %8 %9
)

goto endofperl
:WinNT
IF EXIST "%~dp0perl.exe" (
"%~dp0perl.exe" -x -S %0 %*
) ELSE IF EXIST "%~dp0..\..\bin\perl.exe" (
"%~dp0..\..\bin\perl.exe" -x -S %0 %*
) ELSE (
perl -x -S %0 %*
)

if NOT "%COMSPEC%" == "%SystemRoot%\system32\cmd.exe" goto endofperl
if %errorlevel% == 9009 echo You do not have Perl in your PATH.
if errorlevel 1 goto script_failed_so_exit_with_non_zero_val 2>nul
goto endofperl
@rem ';
#!perl
#line 29
    eval 'exec C:\xampp_old\perl\bin\perl.exe -S $0 ${1+"$@"}'
	if $running_under_some_shell;
#!/usr/bin/perl

use strict;
use Getopt::Long;

use JSON::PP ();

my $VERSION = '1.00';

# imported from JSON-XS/bin/json_xs

my %allow_json_opt = map { $_ => 1 } qw(
    ascii latin1 utf8 pretty indent space_before space_after relaxed canonical allow_nonref
    allow_singlequote allow_barekey allow_bignum loose escape_slash
);


GetOptions(
   'v'   => \( my $opt_verbose ),
   'f=s' => \( my $opt_from = 'json' ),
   't=s' => \( my $opt_to = 'json' ),
   'json_opt=s' => \( my $json_opt = 'pretty' ),
   'V'   => \( my $version ),
) or die "Usage: $0 [-v] -f from_format [-t to_format]\n";


if ( $version ) {
    print "$VERSION\n";
    exit;
}


$json_opt = '' if $json_opt eq '-';

my @json_opt = grep { $allow_json_opt{ $_ } or die "'$_' is invalid json opttion" } split/,/, $json_opt;

my %F = (
   'json' => sub {
      my $json = JSON::PP->new;
      $json->$_() for @json_opt;
      $json->decode( $_ );
   },
   'eval' => sub {
        my $v = eval "no strict;\n#line 1 \"input\"\n$_";
        die "$@" if $@;
        return $v;
    },
);


my %T = (
   'null' => sub { "" },
   'json' => sub {
      my $json = JSON::PP->new;
      $json->$_() for @json_opt;
      $json->encode( $_ );
   },
   'dumper' => sub {
      require Data::Dumper;
      Data::Dumper::Dumper($_)
   },
);



$F{$opt_from}
   or die "$opt_from: not a valid fromformat\n";

$T{$opt_to}
   or die "$opt_from: not a valid toformat\n";

local $/;
$_ = <STDIN>;

$_ = $F{$opt_from}->();
$_ = $T{$opt_to}->();

print $_;


__END__

=pod

=encoding utf8

=head1 NAME

json_pp - JSON::PP command utility

=head1 SYNOPSIS

    json_pp [-v] [-f from_format] [-t to_format] [-json_opt options_to_json]

=head1 DESCRIPTION

json_pp converts between some input and output formats (one of them is JSON).
This program was copied from L<json_xs> and modified.

The default input format is json and the default output format is json with pretty option.

=head1 OPTIONS

=head2 -f

    -f from_format

Reads a data in the given format from STDIN.

Format types:

=over

=item json

as JSON

=item eval

as Perl code

=back

=head2 -t

Writes a data in the given format to STDOUT.

=over

=item null

no action.

=item json

as JSON

=item dumper

as Data::Dumper

=back

=head2 -json_opt

options to JSON::PP

Acceptable options are:

    ascii latin1 utf8 pretty indent space_before space_after relaxed canonical allow_nonref
    allow_singlequote allow_barekey allow_bignum loose escape_slash

=head2 -v

Verbose option, but currently no action in fact.

=head2 -V

Prints version and exits.


=head1 EXAMPLES

    $ perl -e'print q|{"foo":"あい","bar":1234567890000000000000000}|' |\
       json_pp -f json -t dumper -json_opt pretty,utf8,allow_bignum
    
    $VAR1 = {
              'bar' => bless( {
                                'value' => [
                                             '0000000',
                                             '0000000',
                                             '5678900',
                                             '1234'
                                           ],
                                'sign' => '+'
                              }, 'Math::BigInt' ),
              'foo' => "\x{3042}\x{3044}"
            };

    $ perl -e'print q|{"foo":"あい","bar":1234567890000000000000000}|' |\
       json_pp -f json -t dumper -json_opt pretty
    
    $VAR1 = {
              'bar' => '1234567890000000000000000',
              'foo' => "\x{e3}\x{81}\x{82}\x{e3}\x{81}\x{84}"
            };

=head1 SEE ALSO

L<JSON::PP>, L<json_xs>

=head1 AUTHOR

Makamaka Hannyaharamitu, E<lt>makamaka[at]cpan.orgE<gt>


=head1 COPYRIGHT AND LICENSE

Copyright 2010 by Makamaka Hannyaharamitu

This library is free software; you can redistribute it and/or modify
it under the same terms as Perl itself. 

=cut


__END__
:endofperl
