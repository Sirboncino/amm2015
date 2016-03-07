/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    
    //$("#nessuno").hide();
    $(".error").hide(); //hide()
    $("#tabella_segnalazioni").hide();  //hide()
    
    $('#filtra').click(function(event){
        // impedisco il submit
        event.preventDefault(); 
         
        var _categoria_segnalazione = $("#categoria_segnalazione option:selected").attr('value');
        if(_categoria_segnalazione === 'qualsiasi'){
            _categoria_segnalazione = '';
        }
        
        var _priorita = $("#priorita option:selected").attr('value');
        if(_priorita === 'qualsiasi'){
            _priorita = '';
        }
        
        var _status = $("#status option:selected").attr('value');
        if(_status === 'qualsiasi'){
            _status = '';
        }
        
        var _oggetto = $("#oggetto").val();
                
        var par = {
            categoria_segnalazione: _categoria_segnalazione,
            priorita: _priorita,
            status: _status,
            oggetto: _oggetto//,
            };
        
 
        $.ajax({
            url: 'utilizzatore/filtra_segnalazioni',
            data: par,
            dataType: 'json',
            
            //beforeSend: function(){alert("testing");},
     
            success: function (data, state) {
                
                if(data['errori'].length === 0){
                    // nessun errore
                    $(".error").hide();
                    if(data['segnalazioni_trovate'].length === 0){
 
                        // mostro il messaggio per nessun elemento
                        $("#nessuno").show();
                        // nascondo la tabella
                        $("#tabella_segnalazioni").hide();
                        
                       
                    }else{
                        // nascondo il messaggio per nessun elemento
                        $("#nessuno").hide();
                        // mostro la tabella
                        $("#tabella_segnalazioni").show();
                        //cancello tutti gli elementi dalla tabella
                        $("#tabella_segnalazioni tbody").empty();
                       
                        // aggiungo le righe
                        var i = 0;
                        for(var key in data['segnalazioni_trovate']){
                            var segnalazione_trovata = data['segnalazioni_trovate'][key];
                            $("#tabella_segnalazioni tbody").append(
                                "<tr id=\"row_" + i + "\" >\n\
                                       <td>a</td>\n\
                                       <td>a</td>\n\
                                       <td>a</td>\n\
                                       <td>a</td>\n\
                                       <td>a</td>\n\
                                       <td>a</td>\n\
                                 </tr>");
                            if(i%2 != 0){
                                $("#row_" + i).addClass("alt-row");
                            }


                            var colonne = $("#row_"+ i +" td");
                            $(colonne[0]).text(segnalazione_trovata['data_creazione']);
                            $(colonne[1]).text(segnalazione_trovata['numero']);
                            $(colonne[2]).text(segnalazione_trovata['status']);
                            $(colonne[3]).text(segnalazione_trovata['data_status']);
                            $(colonne[4]).text(segnalazione_trovata['categoria']);
                            $(colonne[5]).text(segnalazione_trovata['oggetto']);

                            i++;
                        }
                    }
                }else{
                    $(".error").show();
                    $(".error ul").empty();
                    for(var k in data['errori']){
                        $(".error ul").append("<li>"+ data['errori'][k] + "<\li>");
                    }
                }
               
            },
            error: function (data, state) {
                alert(error);
            }
        
        });
        
    });
});
