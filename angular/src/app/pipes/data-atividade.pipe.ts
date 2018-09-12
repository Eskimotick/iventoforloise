import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'dataAtividade'
})
export class DataAtividadePipe implements PipeTransform {

  transform(data: string): string {
    if(!data) return '';
    var re = /([-T])/;
    const str = data.split(re);
    return `${str[4]}/${str[2]}/${str[0]}`;
  }

}
