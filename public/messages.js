/*!
 *  Lang.js for Laravel localization in JavaScript.
 *
 *  @version 1.1.10
 *  @license MIT https://github.com/rmariuzzo/Lang.js/blob/master/LICENSE
 *  @site    https://github.com/rmariuzzo/Lang.js
 *  @author  Rubens Mariuzzo <rubens@mariuzzo.com>
 */
(function(root,factory){"use strict";if(typeof define==="function"&&define.amd){define([],factory)}else if(typeof exports==="object"){module.exports=factory()}else{root.Lang=factory()}})(this,function(){"use strict";function inferLocale(){if(typeof document!=="undefined"&&document.documentElement){return document.documentElement.lang}}function convertNumber(str){if(str==="-Inf"){return-Infinity}else if(str==="+Inf"||str==="Inf"||str==="*"){return Infinity}return parseInt(str,10)}var intervalRegexp=/^({\s*(\-?\d+(\.\d+)?[\s*,\s*\-?\d+(\.\d+)?]*)\s*})|([\[\]])\s*(-Inf|\*|\-?\d+(\.\d+)?)\s*,\s*(\+?Inf|\*|\-?\d+(\.\d+)?)\s*([\[\]])$/;var anyIntervalRegexp=/({\s*(\-?\d+(\.\d+)?[\s*,\s*\-?\d+(\.\d+)?]*)\s*})|([\[\]])\s*(-Inf|\*|\-?\d+(\.\d+)?)\s*,\s*(\+?Inf|\*|\-?\d+(\.\d+)?)\s*([\[\]])/;var defaults={locale:"en"};var Lang=function(options){options=options||{};this.locale=options.locale||inferLocale()||defaults.locale;this.fallback=options.fallback;this.messages=options.messages};Lang.prototype.setMessages=function(messages){this.messages=messages};Lang.prototype.getLocale=function(){return this.locale||this.fallback};Lang.prototype.setLocale=function(locale){this.locale=locale};Lang.prototype.getFallback=function(){return this.fallback};Lang.prototype.setFallback=function(fallback){this.fallback=fallback};Lang.prototype.has=function(key,locale){if(typeof key!=="string"||!this.messages){return false}return this._getMessage(key,locale)!==null};Lang.prototype.get=function(key,replacements,locale){if(!this.has(key,locale)){return key}var message=this._getMessage(key,locale);if(message===null){return key}if(replacements){message=this._applyReplacements(message,replacements)}return message};Lang.prototype.trans=function(key,replacements){return this.get(key,replacements)};Lang.prototype.choice=function(key,number,replacements,locale){replacements=typeof replacements!=="undefined"?replacements:{};replacements.count=number;var message=this.get(key,replacements,locale);if(message===null||message===undefined){return message}var messageParts=message.split("|");var explicitRules=[];for(var i=0;i<messageParts.length;i++){messageParts[i]=messageParts[i].trim();if(anyIntervalRegexp.test(messageParts[i])){var messageSpaceSplit=messageParts[i].split(/\s/);explicitRules.push(messageSpaceSplit.shift());messageParts[i]=messageSpaceSplit.join(" ")}}if(messageParts.length===1){return message}for(var j=0;j<explicitRules.length;j++){if(this._testInterval(number,explicitRules[j])){return messageParts[j]}}var pluralForm=this._getPluralForm(number);return messageParts[pluralForm]};Lang.prototype.transChoice=function(key,count,replacements){return this.choice(key,count,replacements)};Lang.prototype._parseKey=function(key,locale){if(typeof key!=="string"||typeof locale!=="string"){return null}var segments=key.split(".");var source=segments[0].replace(/\//g,".");return{source:locale+"."+source,sourceFallback:this.getFallback()+"."+source,entries:segments.slice(1)}};Lang.prototype._getMessage=function(key,locale){locale=locale||this.getLocale();key=this._parseKey(key,locale);if(this.messages[key.source]===undefined&&this.messages[key.sourceFallback]===undefined){return null}var message=this.messages[key.source];var entries=key.entries.slice();var subKey="";while(entries.length&&message!==undefined){var subKey=!subKey?entries.shift():subKey.concat(".",entries.shift());if(message[subKey]!==undefined){message=message[subKey];subKey=""}}if(typeof message!=="string"&&this.messages[key.sourceFallback]){message=this.messages[key.sourceFallback];entries=key.entries.slice();subKey="";while(entries.length&&message!==undefined){var subKey=!subKey?entries.shift():subKey.concat(".",entries.shift());if(message[subKey]){message=message[subKey];subKey=""}}}if(typeof message!=="string"){return null}return message};Lang.prototype._findMessageInTree=function(pathSegments,tree){while(pathSegments.length&&tree!==undefined){var dottedKey=pathSegments.join(".");if(tree[dottedKey]){tree=tree[dottedKey];break}tree=tree[pathSegments.shift()]}return tree};Lang.prototype._applyReplacements=function(message,replacements){for(var replace in replacements){message=message.replace(new RegExp(":"+replace,"gi"),function(match){var value=replacements[replace];var allCaps=match===match.toUpperCase();if(allCaps){return value.toUpperCase()}var firstCap=match===match.replace(/\w/i,function(letter){return letter.toUpperCase()});if(firstCap){return value.charAt(0).toUpperCase()+value.slice(1)}return value})}return message};Lang.prototype._testInterval=function(count,interval){if(typeof interval!=="string"){throw"Invalid interval: should be a string."}interval=interval.trim();var matches=interval.match(intervalRegexp);if(!matches){throw"Invalid interval: "+interval}if(matches[2]){var items=matches[2].split(",");for(var i=0;i<items.length;i++){if(parseInt(items[i],10)===count){return true}}}else{matches=matches.filter(function(match){return!!match});var leftDelimiter=matches[1];var leftNumber=convertNumber(matches[2]);if(leftNumber===Infinity){leftNumber=-Infinity}var rightNumber=convertNumber(matches[3]);var rightDelimiter=matches[4];return(leftDelimiter==="["?count>=leftNumber:count>leftNumber)&&(rightDelimiter==="]"?count<=rightNumber:count<rightNumber)}return false};Lang.prototype._getPluralForm=function(count){switch(this.locale){case"az":case"bo":case"dz":case"id":case"ja":case"jv":case"ka":case"km":case"kn":case"ko":case"ms":case"th":case"tr":case"vi":case"zh":return 0;case"af":case"bn":case"bg":case"ca":case"da":case"de":case"el":case"en":case"eo":case"es":case"et":case"eu":case"fa":case"fi":case"fo":case"fur":case"fy":case"gl":case"gu":case"ha":case"he":case"hu":case"is":case"it":case"ku":case"lb":case"ml":case"mn":case"mr":case"nah":case"nb":case"ne":case"nl":case"nn":case"no":case"om":case"or":case"pa":case"pap":case"ps":case"pt":case"so":case"sq":case"sv":case"sw":case"ta":case"te":case"tk":case"ur":case"zu":return count==1?0:1;case"am":case"bh":case"fil":case"fr":case"gun":case"hi":case"hy":case"ln":case"mg":case"nso":case"xbr":case"ti":case"wa":return count===0||count===1?0:1;case"be":case"bs":case"hr":case"ru":case"sr":case"uk":return count%10==1&&count%100!=11?0:count%10>=2&&count%10<=4&&(count%100<10||count%100>=20)?1:2;case"cs":case"sk":return count==1?0:count>=2&&count<=4?1:2;case"ga":return count==1?0:count==2?1:2;case"lt":return count%10==1&&count%100!=11?0:count%10>=2&&(count%100<10||count%100>=20)?1:2;case"sl":return count%100==1?0:count%100==2?1:count%100==3||count%100==4?2:3;case"mk":return count%10==1?0:1;case"mt":return count==1?0:count===0||count%100>1&&count%100<11?1:count%100>10&&count%100<20?2:3;case"lv":return count===0?0:count%10==1&&count%100!=11?1:2;case"pl":return count==1?0:count%10>=2&&count%10<=4&&(count%100<12||count%100>14)?1:2;case"cy":return count==1?0:count==2?1:count==8||count==11?2:3;case"ro":return count==1?0:count===0||count%100>0&&count%100<20?1:2;case"ar":return count===0?0:count==1?1:count==2?2:count%100>=3&&count%100<=10?3:count%100>=11&&count%100<=99?4:5;default:return 0}};return Lang});

(function () {
    Lang = new Lang();
    Lang.setMessages({"en.auth":{"failed":"These credentials do not match our records.","password":"The provided password is incorrect.","throttle":"Too many login attempts. Please try again in :seconds seconds."},"en.main":{"auth":{"confirm_password":"Confirm Password","email":"E-mail","forgot_password":"Forgot Your Password?","invalid_credentials":"Invalid e-mail or password","login":"Login","messages":{"invalid_mail":"Invalid mail.","min_password":"Usually passwords has 8 or more chars.","required_mail":"The email field is required.","required_password":"You must input some password."},"password":"Password","reset_password":{"default_email_error":"Please, verify if the e-mail address belongs to a active user.","default_password_error":"Passwords must have atleast 8 characters, and be confirmed.","instructions":"Inform your e-mail address, and we will send you a mail with the link for password reset.","reset_instructions":"Confirm your e-mail address and inform your new password.","send_password_link":"Send Password Reset Link","title":"Reset password"},"reset_password_action":"Reset Password"},"farms":{"actions":{"edit_farm":"Edit farm","new_farm":"Create new farm","remove_farm":"Remove farm"},"created":"Farm created successfully","creating_alert":"You can add shapes and plots in this farm after creation.","filters":{"search":"Filter"},"removed":"Farm removed successfully","select_alert":"Select a farm on the left menu","table":{"name":"Farm Name"},"title":"Registered Farms","to_remove":"Are you sure you want to remove :farm ?","updated":"Farm updated successfully"},"general":{"actions":{"cancel":"Cancel","close":"Close","confirm":"Confirm","delete":"Remove","details":"Details","edit":"Edit","save":"Save"},"home":"Home","loading":"loading","logout":"Logout","validation":{"type_something":"You need to inform some data."}},"localization":{"switcher_error":"Error on changing app language, try again later."},"plot":{"actions":{"new_plot":"Add Plot","remove_plot":"Remove Plot","select_plot":"Select a Plot"},"created":"Plot added successfully","form":{"file":"Load a .geo.json or the .shp with it .shx .prj and .dbf dependencies","file_field":"Ref File","identification":"Name or Reference","invalid_file":"Invalid plot file, check if is a valid .geo.json or or the .shp with it .shx .prj and .dbf dependencies."},"invalid_map_load":"Looks like we can't render this geojson file, try to remove this plot and upload another one","no_loaded":"Select a plot to view on map","removed":"Plot removed successfully","to_remove":"Are you sure you want to remove :plot ?"},"producers":{"actions":{"edit_producer":"Edit Producer","new_producer":"New Producer"},"created":"Producer created successfully","detail_title":"Producer Detail","filters":{"any":"Any","collective":"Collective","individual":"Individual","producer_type":"Producer Type","search":"Search"},"removed":"Producer removed successfully","table":{"city":"City","company_name":"Company Name","localization":"Localization","phone":"Phone","social_number":"Social Number","state":"State","state_registration":"State Registration","trade_name":"Trade Name"},"title":"Manage Producers","to_remove":"Are you sure you want to remove :producer ?","updated":"Producer updated successfully"}},"en.pagination":{"next":"Next &raquo;","previous":"&laquo; Previous"},"en.passwords":{"reset":"Your password has been reset.","sent":"We have emailed your password reset link.","throttled":"Please wait before retrying.","token":"This password reset token is invalid.","user":"We can't find a user with that email address."},"en.strings":{"All rights reserved.":"All rights reserved.","Hello!":"Hi!","If you did not request a password reset, no further action is required.":"If you did not request a password reset, just ignore this mail.","If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\ninto your web browser:":"If you're having any trouble clicking the \":actionText\" button, copy and paste the URL below\non your web browser","Reset Password":"Reset your password","Reset Password Notification":"This is your Password Link","This password reset link will expire in :count minutes.":"The password reset link will expire in :count minutes.","Whoops!":"Whoops","You are receiving this email because we received a password reset request for your account.":"You are receiving this email because we received a password reset request for your account. "},"en.swal":{"ok":"Ok!"},"en.validation":{"accepted":"The :attribute field must be accepted.","accepted_if":"The :attribute field must be accepted when :other is :value.","active_url":"The :attribute field must be a valid URL.","after":"The :attribute field must be a date after :date.","after_or_equal":"The :attribute field must be a date after or equal to :date.","alpha":"The :attribute field must only contain letters.","alpha_dash":"The :attribute field must only contain letters, numbers, dashes, and underscores.","alpha_num":"The :attribute field must only contain letters and numbers.","array":"The :attribute field must be an array.","ascii":"The :attribute field must only contain single-byte alphanumeric characters and symbols.","attributes":[],"before":"The :attribute field must be a date before :date.","before_or_equal":"The :attribute field must be a date before or equal to :date.","between":{"array":"The :attribute field must have between :min and :max items.","file":"The :attribute field must be between :min and :max kilobytes.","numeric":"The :attribute field must be between :min and :max.","string":"The :attribute field must be between :min and :max characters."},"boolean":"The :attribute field must be true or false.","can":"The :attribute field contains an unauthorized value.","confirmed":"The :attribute field confirmation does not match.","current_password":"The password is incorrect.","custom":{"attribute-name":{"rule-name":"custom-message"}},"date":"The :attribute field must be a valid date.","date_equals":"The :attribute field must be a date equal to :date.","date_format":"The :attribute field must match the format :format.","decimal":"The :attribute field must have :decimal decimal places.","declined":"The :attribute field must be declined.","declined_if":"The :attribute field must be declined when :other is :value.","different":"The :attribute field and :other must be different.","digits":"The :attribute field must be :digits digits.","digits_between":"The :attribute field must be between :min and :max digits.","dimensions":"The :attribute field has invalid image dimensions.","distinct":"The :attribute field has a duplicate value.","doesnt_end_with":"The :attribute field must not end with one of the following: :values.","doesnt_start_with":"The :attribute field must not start with one of the following: :values.","email":"The :attribute field must be a valid email address.","ends_with":"The :attribute field must end with one of the following: :values.","enum":"The selected :attribute is invalid.","exists":"The selected :attribute is invalid.","file":"The :attribute field must be a file.","filled":"The :attribute field must have a value.","gt":{"array":"The :attribute field must have more than :value items.","file":"The :attribute field must be greater than :value kilobytes.","numeric":"The :attribute field must be greater than :value.","string":"The :attribute field must be greater than :value characters."},"gte":{"array":"The :attribute field must have :value items or more.","file":"The :attribute field must be greater than or equal to :value kilobytes.","numeric":"The :attribute field must be greater than or equal to :value.","string":"The :attribute field must be greater than or equal to :value characters."},"image":"The :attribute field must be an image.","in":"The selected :attribute is invalid.","in_array":"The :attribute field must exist in :other.","integer":"The :attribute field must be an integer.","ip":"The :attribute field must be a valid IP address.","ipv4":"The :attribute field must be a valid IPv4 address.","ipv6":"The :attribute field must be a valid IPv6 address.","json":"The :attribute field must be a valid JSON string.","lowercase":"The :attribute field must be lowercase.","lt":{"array":"The :attribute field must have less than :value items.","file":"The :attribute field must be less than :value kilobytes.","numeric":"The :attribute field must be less than :value.","string":"The :attribute field must be less than :value characters."},"lte":{"array":"The :attribute field must not have more than :value items.","file":"The :attribute field must be less than or equal to :value kilobytes.","numeric":"The :attribute field must be less than or equal to :value.","string":"The :attribute field must be less than or equal to :value characters."},"mac_address":"The :attribute field must be a valid MAC address.","max":{"array":"The :attribute field must not have more than :max items.","file":"The :attribute field must not be greater than :max kilobytes.","numeric":"The :attribute field must not be greater than :max.","string":"The :attribute field must not be greater than :max characters."},"max_digits":"The :attribute field must not have more than :max digits.","mimes":"The :attribute field must be a file of type: :values.","mimetypes":"The :attribute field must be a file of type: :values.","min":{"array":"The :attribute field must have at least :min items.","file":"The :attribute field must be at least :min kilobytes.","numeric":"The :attribute field must be at least :min.","string":"The :attribute field must be at least :min characters."},"min_digits":"The :attribute field must have at least :min digits.","missing":"The :attribute field must be missing.","missing_if":"The :attribute field must be missing when :other is :value.","missing_unless":"The :attribute field must be missing unless :other is :value.","missing_with":"The :attribute field must be missing when :values is present.","missing_with_all":"The :attribute field must be missing when :values are present.","multiple_of":"The :attribute field must be a multiple of :value.","not_in":"The selected :attribute is invalid.","not_regex":"The :attribute field format is invalid.","numeric":"The :attribute field must be a number.","password":{"letters":"The :attribute field must contain at least one letter.","mixed":"The :attribute field must contain at least one uppercase and one lowercase letter.","numbers":"The :attribute field must contain at least one number.","symbols":"The :attribute field must contain at least one symbol.","uncompromised":"The given :attribute has appeared in a data leak. Please choose a different :attribute."},"present":"The :attribute field must be present.","prohibited":"The :attribute field is prohibited.","prohibited_if":"The :attribute field is prohibited when :other is :value.","prohibited_unless":"The :attribute field is prohibited unless :other is in :values.","prohibits":"The :attribute field prohibits :other from being present.","regex":"The :attribute field format is invalid.","required":"The :attribute field is required.","required_array_keys":"The :attribute field must contain entries for: :values.","required_if":"The :attribute field is required when :other is :value.","required_if_accepted":"The :attribute field is required when :other is accepted.","required_unless":"The :attribute field is required unless :other is in :values.","required_with":"The :attribute field is required when :values is present.","required_with_all":"The :attribute field is required when :values are present.","required_without":"The :attribute field is required when :values is not present.","required_without_all":"The :attribute field is required when none of :values are present.","same":"The :attribute field must match :other.","size":{"array":"The :attribute field must contain :size items.","file":"The :attribute field must be :size kilobytes.","numeric":"The :attribute field must be :size.","string":"The :attribute field must be :size characters."},"starts_with":"The :attribute field must start with one of the following: :values.","string":"The :attribute field must be a string.","timezone":"The :attribute field must be a valid timezone.","ulid":"The :attribute field must be a valid ULID.","unique":"The :attribute has already been taken.","uploaded":"The :attribute failed to upload.","uppercase":"The :attribute field must be uppercase.","url":"The :attribute field must be a valid URL.","uuid":"The :attribute field must be a valid UUID."},"es.strings":{"All rights reserved.":"Reservados todos los derechos.","Hello!":"\u00a1Hola!","If you did not request a password reset, no further action is required.":"Si no solicit\u00f3 un restablecimiento de contrase\u00f1a, simplemente ignore este correo.","If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\ninto your web browser:":"Si tiene problemas para hacer clic en el bot\u00f3n \":actionText\", copie y pegue la siguiente URL\n","Reset Password":"Restablecer su contrase\u00f1a","Reset Password Notification":"Este es su enlace de contrase\u00f1a","This password reset link will expire in :count minutes.":"El enlace de restablecimiento de contrase\u00f1a caducar\u00e1 en :count minutos.","Whoops!":"Ups","You are receiving this email because we received a password reset request for your account.":"Est\u00e1 recibiendo este correo electr\u00f3nico porque recibimos una solicitud de restablecimiento de contrase\u00f1a para su cuenta. "},"pt-BR.auth":{"failed":"Essas credenciais n\u00e3o correspondem com os nossos registros.","throttle":"Voc\u00ea realizou muitas tentativas de login. Por favor, tente novamente em :seconds segundos."},"pt-BR.main":{"auth":{"confirm_password":"Confirmar Senha","email":"E-mail","forgot_password":"Esqueceu sua senha?","invalid_credentials":"E-mail ou senha inv\u00e1lidos","login":"Login","messages":{"invalid_mail":"E-mail inv\u00e1lido.","min_password":"Senhas possuem mais de 8 caracteres.","required_mail":"O campo e-mail \u00e9 obrigat\u00f3rio.","required_password":"Voc\u00ea precisa informar sua senha."},"password":"Senha","reset_password":{"default_email_error":"Por favor, verifique se o e-mail pertence a um usu\u00e1rio ativo.","default_password_error":"Senhas precisam ter ao menos 8 caracteres e ser confirmada.","instructions":"Informe seu endere\u00e7o de e-mail e enviaremos um link para a altera\u00e7\u00e3o de sua senha.","reset_instructions":"Confirme seu endere\u00e7o de e-mail e informe sua nova senha.","send_password_link":"Enviar link de altera\u00e7\u00e3o de senha","title":"Alterar senha"},"reset_password_action":"Alterar Senha"},"farms":{"actions":{"edit_farm":"Editar Fazenda","new_farm":"Nova Fazenda","remove_farm":"Remover Fazenda"},"created":"Fazenda criada com sucesso","creating_alert":"Voc\u00ea pode adicionar contornos e talh\u00f5es na fazenda ap\u00f3s a cria\u00e7\u00e3o.","filters":{"search":"Filtrar"},"removed":"Fazenda removida com sucesso","select_alert":"Selecione uma fazenda no menu a esquerda","table":{"name":"Nome da fazenda"},"title":"Fazendas","to_remove":"Tem certeza que deseja remover :farm ?","updated":"Fazenda criada com sucesso"},"general":{"actions":{"cancel":"Cancelar","close":"Fechar","confirm":"Confirmar","delete":"Remover","details":"Detalhes","edit":"Editar","save":"Salvar"},"home":"In\u00edcio","loading":"carregando","logout":"Sair","validation":{"type_something":"Voc\u00ea precisa informar algo."}},"localization":{"switcher_error":"Erro ao alterar o idioma, tente novamente mais tarde."},"plot":{"actions":{"new_plot":"Adicionar Talh\u00e3o","remove_plot":"Remover Talh\u00e3o","select_plot":"Selecione um Talh\u00e3o"},"created":"Talh\u00e3o adicionado com sucesso","form":{"file":"Carregue um arquivo .geo.json ou .shp com suas depend\u00eancias .shx .prj e .dbf","file_field":"Arquivo Refer\u00eancia","identification":"Nome ou Refer\u00eancia","invalid_file":"Arquivo de talh\u00e3o inv\u00e1lido, verifique se \u00e9 .geo.json v\u00e1lido ou se o .shp foi carregado com suas depend\u00eancias"},"invalid_map_load":"Parece que n\u00e3o conseguimos renderizar o arquivo geojson, tente remover o talh\u00e3o e adicionar outro.","no_loaded":"Selecione um talh\u00e3o para ser exibido no mapa","removed":"Talh\u00e3o removido com sucesso","to_remove":"Tem certeza que deseja remover :plot ?"},"producers":{"actions":{"edit_producer":"Editar Produtor","new_producer":"Novo Produtor"},"created":"Produtor criado com sucesso","detail_title":"Detalhes do Produtor","filters":{"any":"Qualquer","collective":"Pessoa Jur\u00eddica","individual":"Pessoa F\u00edsica","producer_type":"Tipo do Produtor","search":"Procurar"},"removed":"Produtor removido com sucesso","table":{"city":"Cidade","company_name":"Raz\u00e3o Social","localization":"Localiza\u00e7\u00e3o","phone":"Telefone","social_number":"CPF\/CNPJ","state":"Estado","state_registration":"Inscri\u00e7\u00e3o Estadual","trade_name":"Nome Fantasia"},"title":"Gerenciar Produtores","to_remove":"Voc\u00ea tem certeza que deseja remover :producer ?","updated":"Produtor atualizado com sucesso"}},"pt-BR.pagination":{"next":"Pr\u00f3ximo &raquo;","previous":"&laquo; Anterior"},"pt-BR.passwords":{"password":"As senhas devem ter pelo menos seis caracteres e corresponder \u00e0 confirma\u00e7\u00e3o.","reset":"Sua senha foi alterada!","sent":"Enviamos para seu e-mail um link de redefini\u00e7\u00e3o de senha!","token":"Este token de redefini\u00e7\u00e3o de senha \u00e9 inv\u00e1lido.","user":"N\u00e3o conseguimos encontrar um usu\u00e1rio com esse endere\u00e7o de e-mail."},"pt-BR.strings":{"All rights reserved.":"Todos os direitos reservados.","Hello!":"Ol\u00e1!","If you did not request a password reset, no further action is required.":"Se voc\u00ea n\u00e3o fez essa solicita\u00e7\u00e3o, apenas ignore este e-mail.","If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\ninto your web browser:":"Se voc\u00ea enfrenta problemas ao clicar em \":actionText\", copie e cole a url a baixo em seu navegador","Reset Password":"Alterar senha","Reset Password Notification":"Seu link de altera\u00e7\u00e3o de senha.","This password reset link will expire in :count minutes.":"O link de altera\u00e7\u00e3o de senha expira em :count minutos.","Whoops!":"Oops","You are receiving this email because we received a password reset request for your account.":"Voc\u00ea esta recebendo esse e-mail pois solicitou a altera\u00e7\u00e3o de sua senha. "},"pt-BR.swal":{"ok":"Ok!"},"pt-BR.validation":{"accepted":"O campo :attribute deve ser aceito.","active_url":"O campo :attribute n\u00e3o \u00e9 uma URL v\u00e1lida.","after":"O campo :attribute deve ser uma data posterior a :date.","after_or_equal":"O campo :attribute deve ser uma data superior ou igual a :date.","alpha":"O campo :attribute deve ser apenas letras.","alpha_dash":"O campo :attribute s\u00f3 pode conter letras, n\u00fameros e tra\u00e7os.","alpha_num":"O campo :attribute s\u00f3 pode conter letras e n\u00fameros.","array":"O campo :attribute deve conter um array.","attributes":{"address":"endere\u00e7o","age":"idade","body":"conte\u00fado","city":"cidade","country":"pa\u00eds","date":"data","day":"dia","description":"descri\u00e7\u00e3o","excerpt":"resumo","first_name":"primeiro nome","gender":"g\u00eanero","hour":"hora","last_name":"sobrenome","message":"mensagem","minute":"minuto","mobile":"celular","month":"m\u00eas","name":"nome","password":"senha","password_confirmation":"confirma\u00e7\u00e3o da senha","phone":"telefone","second":"segundo","sex":"sexo","state":"estado","subject":"assunto","text":"texto","time":"hora","title":"t\u00edtulo","username":"usu\u00e1rio","year":"ano"},"before":"O campo :attribute deve conter uma data anterior a :date.","before_or_equal":"O campo :attribute deve conter uma data inferior ou igual a :date.","between":{"array":"O campo :attribute deve conter de :min a :max itens.","file":"O campo :attribute deve conter um arquivo de :min a :max kilobytes.","numeric":"O campo :attribute deve conter um n\u00famero entre :min e :max.","string":"O campo :attribute deve conter entre :min a :max caracteres."},"boolean":"O campo :attribute deve conter o valor verdadeiro ou falso.","confirmed":"A confirma\u00e7\u00e3o para o campo :attribute n\u00e3o coincide.","custom":{"attribute-name":{"rule-name":"custom-message"}},"date":"O campo :attribute n\u00e3o cont\u00e9m uma data v\u00e1lida.","date_format":"A data informada para o campo :attribute n\u00e3o respeita o formato :format.","different":"Os campos :attribute e :other devem conter valores diferentes.","digits":"O campo :attribute deve conter :digits d\u00edgitos.","digits_between":"O campo :attribute deve conter entre :min a :max d\u00edgitos.","dimensions":"O valor informado para o campo :attribute n\u00e3o \u00e9 uma dimens\u00e3o de imagem v\u00e1lida.","distinct":"O campo :attribute cont\u00e9m um valor duplicado.","email":"O campo :attribute n\u00e3o cont\u00e9m um endere\u00e7o de email v\u00e1lido.","exists":"O valor selecionado para o campo :attribute \u00e9 inv\u00e1lido.","file":"O campo :attribute deve conter um arquivo.","filled":"O campo :attribute \u00e9 obrigat\u00f3rio.","gt":{"array":"O campo :attribute deve ter mais que :value items.","file":"O campo :attribute deve ser maior que :value kilobytes.","numeric":"O campo :attribute deve ser maior que :value.","string":"O campo :attribute deve ser maior que :value caracteres."},"gte":{"array":"O campo :attribute deve ter :value items ou mais.","file":"O campo :attribute deve ser maior ou igual a :value kilobytes.","numeric":"O campo :attribute deve ser maior ou igual a :value.","string":"O campo :attribute deve ser maior ou igual a :value caracteres."},"image":"O campo :attribute deve conter uma imagem.","in":"O campo :attribute n\u00e3o cont\u00e9m um valor v\u00e1lido.","in_array":"O campo :attribute n\u00e3o existe em :other.","integer":"O campo :attribute deve conter um n\u00famero inteiro.","ip":"O campo :attribute deve conter um IP v\u00e1lido.","ipv4":"O campo :attribute deve conter um IPv4 v\u00e1lido.","ipv6":"O campo :attribute deve conter um IPv6 v\u00e1lido.","json":"O campo :attribute deve conter uma string JSON v\u00e1lida.","lt":{"array":"O campo :attribute deve ter menos do que :value items.","file":"O campo :attribute deve ser menor que :value kilobytes.","numeric":"O campo :attribute deve ser menor que :value.","string":"O campo :attribute deve ser menor que :value caracteres."},"lte":{"array":"O campo :attribute n\u00e3o deve ter mais do que :value items.","file":"O campo :attribute deve ser menor ou igual a :value kilobytes.","numeric":"O campo :attribute deve ser menor ou igual a :value.","string":"O campo :attribute deve ser menor ou igual a :value caracteres."},"max":{"array":"O campo :attribute deve conter no m\u00e1ximo :max itens.","file":"O campo :attribute n\u00e3o pode conter um arquivo com mais de :max kilobytes.","numeric":"O campo :attribute n\u00e3o pode conter um valor superior a :max.","string":"O campo :attribute n\u00e3o pode conter mais de :max caracteres."},"mimes":"O campo :attribute deve conter um arquivo do tipo: :values.","mimetypes":"O campo :attribute deve conter um arquivo do tipo: :values.","min":{"array":"O campo :attribute deve conter no m\u00ednimo :min itens.","file":"O campo :attribute deve conter um arquivo com no m\u00ednimo :min kilobytes.","numeric":"O campo :attribute deve conter um n\u00famero superior ou igual a :min.","string":"O campo :attribute deve conter no m\u00ednimo :min caracteres."},"not_in":"O campo :attribute cont\u00e9m um valor inv\u00e1lido.","not_regex":"The :attribute format is invalid.","numeric":"O campo :attribute deve conter um valor num\u00e9rico.","present":"O campo :attribute deve estar presente.","regex":"O formato do valor informado no campo :attribute \u00e9 inv\u00e1lido.","required":"O campo :attribute \u00e9 obrigat\u00f3rio.","required_if":"O campo :attribute \u00e9 obrigat\u00f3rio quando o valor do campo :other \u00e9 igual a :value.","required_unless":"O campo :attribute \u00e9 obrigat\u00f3rio a menos que :other esteja presente em :values.","required_with":"O campo :attribute \u00e9 obrigat\u00f3rio quando :values est\u00e1 presente.","required_with_all":"O campo :attribute \u00e9 obrigat\u00f3rio quando um dos :values est\u00e1 presente.","required_without":"O campo :attribute \u00e9 obrigat\u00f3rio quando :values n\u00e3o est\u00e1 presente.","required_without_all":"O campo :attribute \u00e9 obrigat\u00f3rio quando nenhum dos :values est\u00e1 presente.","same":"Os campos :attribute e :other devem conter valores iguais.","size":{"array":"O campo :attribute deve conter :size itens.","file":"O campo :attribute deve conter um arquivo com o tamanho de :size kilobytes.","numeric":"O campo :attribute deve conter o n\u00famero :size.","string":"O campo :attribute deve conter :size caracteres."},"string":"O campo :attribute deve ser uma string.","timezone":"O campo :attribute deve conter um fuso hor\u00e1rio v\u00e1lido.","unique":"O valor informado para o campo :attribute j\u00e1 est\u00e1 em uso.","uploaded":"Falha no Upload do arquivo :attribute.","url":"O formato da URL informada para o campo :attribute \u00e9 inv\u00e1lido."}});
})();
