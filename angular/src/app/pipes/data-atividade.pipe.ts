import { Pipe, PipeTransform } from '@angular/core';
import * as moment from 'moment';

@Pipe({
  name: 'dataAtividade'
})
export class DataAtividadePipe implements PipeTransform {

  transform(data: string): string {
  	if(!data) return '';
  	return moment(data).format('DD/MM/YYYY');
  }

}
