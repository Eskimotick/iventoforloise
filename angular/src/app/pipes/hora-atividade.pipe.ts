import { Pipe, PipeTransform } from '@angular/core';
import * as moment from 'moment';

@Pipe({
  name: 'horaAtividade'
})
export class HoraAtividadePipe implements PipeTransform {

  transform(hora: string): string {
  	if(!hora) return '';
  	return moment(hora).format('HH:mm');
  }

}
