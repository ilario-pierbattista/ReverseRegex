# ReverseRegex

[![Tests](https://github.com/trust-psp/reverse-regex/actions/workflows/ci.yaml/badge.svg?branch=master)](https://github.com/trust-psp/reverse-regex/actions/workflows/ci.yaml)

Generate strings matching a supported regular-expression pattern.

This package requires PHP 8.5 or newer. It is a maintained wrapper around the
legacy `ilario-pierbattista/reverse-regex` implementation.

## Installation

```shell
composer require trust-psp/reverse-regex
```

## Usage

`Trust\ReverseRegex` is the only public API. Classes in the `ReverseRegex` and
`PHPStats` namespaces are internal implementation details.

```php
use Trust\ReverseRegex;

$generator = new ReverseRegex();
$identifier = $generator->generate('T[2345679ACDEFGHJKLMNPQRSTUVWXYZ]{9}');
```

Patterns must not include delimiters such as `/.../`. Generated values are
limited to 40 characters. Patterns that can exceed this limit, including `*`
and `+` quantifiers, throw `LengthException`. Invalid or unsupported patterns
throw `InvalidArgumentException`.

Generation uses PHP's cryptographically secure `random_int()`. Randomness alone
does not guarantee uniqueness, so persisted identifiers must also have a unique
database constraint and collision retry.

## Writing A Regex

1. Escape regex metacharacters that should be generated literally.
2. Not all regex features are supported; see the table below.
3. Use `\X{####}` for Unicode values and `[\X{####}-\X{####}]` for ranges.
4. Unicode properties such as `\p` are not supported.
5. Quantifiers apply to the preceding group, literal, or character class.
6. The maximum possible generated length must not exceed 40 characters.

### Regex Support

<table>
 <tr>
  <th>
    Example
  </th>
  <th>
    Description
  </th>
  <th>
    Resulting String
  </th>
 </tr>
 
 <tr>
  <td> (abcf) </td> <td> Support literals this would generate string </td> <td>`abcf`</td>  
 </tr>
 <tr>
   <td> \((abcf)\) </td> <td> Escape meta characters as you normally would in a regex </td> <td>`(abcf)`</td>  
 </tr>
 <tr>
  <td> [a-z] </td> <td> Character Classes are supported </td> <td>`a`</td>  
 </tr>
 <tr>
  <td> a{5} </td> <td> Quantifiers supported always <strong>last</strong> group or literal or character class </td> <td>`aaaaa`</td>  
 </tr>
 <tr>
  <td> a{1,5} </td> <td> Range Quantifiers supported</td> <td>`aa`</td>  
 </tr>
 <tr>
  <td> a|b|c </td> <td> Alternation supported pick one of three at random </td> <td>`b`</td>  
 </tr>
 <tr>
  <td> a|(y|d){5} </td> <td> Groups supported with alternation and quantifiers </td> <td>`ddddd` or `a` or `yyyyy` </td>  
 </tr>
 <tr>
  <tr>
    <td> \d </td> <td> Digit shorthand equ [0-9]  </td> <td>`1`</td>  
  </tr>
  <tr>
    <td> \w </td><td> word character shorthand equ [a-zA-Z0-9_]  </td> <td>`j`</td>  
  </tr>
  <tr>
    <td> \W </td><td>Non word character shorthand equ [^a-zA-Z0-9_]  </td> <td>`j`</td>  
  </tr>
  <tr>
    <td> \s </td><td>White space shorthand ASCII only </td> <td>` `</td>  
  </tr>
  <tr>
    <td> \S </td><td>Non White space shorthand ASCII only </td> <td>`i`</td>  
  </tr>
  <tr>
    <td> . </td><td>Dot all ASCII characters </td> <td>`$`</td>  
  </tr>
  <tr>
    <td> * + ? </td><td>Short hand quantifiers, recommend not use them </td> <td> </td>  
  </tr>
  <tr>
    <td> \X{00FF}[\X{00FF}-\X{00FF}] </td><td>Unicode ranges</td> <td> </td>  
  </tr>
  <tr>
    <td> \xFF[\xFF-\xFF] </td><td> Hex ranges</td> <td> </td>  
  </tr>
 </table>


