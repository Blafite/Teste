@component('mail::message')
<h1>Olá {{$usuario->nome}},</h1>
<p>Segue abaixo o seu token para realizar a alteração de senha:</p>
<h2>{{$usuario->token}}</h2>
@component('mail::button', ['url' => 'https://globo.com'])
Alterar Senha
@endcomponent
<p>Atenciosamente,</p>
<p>CertificaCoop</p>
@endcomponent