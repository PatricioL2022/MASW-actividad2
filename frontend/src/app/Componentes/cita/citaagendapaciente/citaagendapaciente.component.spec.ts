import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CitaagendapacienteComponent } from './citaagendapaciente.component';

describe('CitaagendapacienteComponent', () => {
  let component: CitaagendapacienteComponent;
  let fixture: ComponentFixture<CitaagendapacienteComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CitaagendapacienteComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CitaagendapacienteComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
