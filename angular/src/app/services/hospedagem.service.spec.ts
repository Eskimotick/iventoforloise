import { TestBed, inject } from '@angular/core/testing';

import { HospedagemService } from './hospedagem.service';

describe('HospedagemService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [HospedagemService]
    });
  });

  it('should be created', inject([HospedagemService], (service: HospedagemService) => {
    expect(service).toBeTruthy();
  }));
});
