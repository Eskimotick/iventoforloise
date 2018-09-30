import { TestBed, inject } from '@angular/core/testing';

import { AtividadesService } from './atividades.service';

describe('AtividadesService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [AtividadesService]
    });
  });

  it('should be created', inject([AtividadesService], (service: AtividadesService) => {
    expect(service).toBeTruthy();
  }));
});
