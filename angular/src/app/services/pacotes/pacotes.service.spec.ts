import { TestBed, inject } from '@angular/core/testing';

import { PacotesService } from './pacotes.service';

describe('PacotesService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [PacotesService]
    });
  });

  it('should be created', inject([PacotesService], (service: PacotesService) => {
    expect(service).toBeTruthy();
  }));
});
