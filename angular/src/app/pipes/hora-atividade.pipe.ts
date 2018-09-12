import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'horaAtividade'
})
export class HoraAtividadePipe implements PipeTransform {

  transform(hora: string): string {
  	if(!hora) return '';
    var re = /([-T:])/;
    const str = hora.split(re);
    console.log(str);
    return `${str[6]}:${str[8]}`;
  }

}
