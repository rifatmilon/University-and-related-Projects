import numpy as np
from scipy.spatial.distance import euclidean
from scipy.spatial.distance import cosine
from scipy.spatial.distance import cityblock
from scipy.stats import pearsonr

def create_matrix(rows, cols, illumination_values):
    matrix = [[0] * cols for _ in range(rows)]
    for x, y in illumination_values:
        matrix[y - 1][x - 1] = 1  # Swap x and y indices
    return matrix

def calculate_moments(matrix):
    m00 = 0
    m10 = 0
    m01 = 0

    for i in range(len(matrix)):
        for j in range(len(matrix[0])):
            if matrix[i][j] == 1:
                m00 += 1
                m10 += j + 1
                m01 += i + 1
    return m10, m01, m00

def calculate_moments_dictionary(m00, m10, m01, matrix):
    moments = {}
    for p in range(4):
        for q in range(4):
            moment = 0
            for i in range(len(matrix)):
                for j in range(len(matrix[0])):
                    if matrix[i][j] == 1:
                        moment += ((j + 1 - (m10 / m00)) ** p) * ((i + 1 - (m01 / m00)) ** q)
            moments[(p, q)] = moment
    return moments

def calculate_rotation_invariants(moments):
    μ02 = moments[(0, 2)]
    μ20 = moments[(2, 0)]
    μ30 = moments[(3, 0)]
    μ03 = moments[(0, 3)]
    μ11 = moments[(1, 1)]
    μ12 = moments[(1, 2)]

    R1 = μ02 + μ20
    R2 = (μ20 - μ02) ** 2 + 4 * μ11 ** 2
    R3 = (μ30 - 3 * μ12) ** 2 + (3 * μ12 - μ03) ** 2
    R4 = (μ30 + μ12) ** 2 + (μ12 + μ03) ** 2
    R5 = (μ30 - 3 * μ12) * (μ30 + μ12) * ((μ30 + μ12) ** 2 - 3 * (μ12 + μ03) ** 2) + (3 * μ12 - μ03) * (μ12 + μ03) * (3 * (μ30 + μ12) ** 2 - (μ12 + μ03) ** 2)
    R6 = (μ20 - μ02) * ((μ30 + μ12) ** 2 - (μ12 + μ03) ** 2) + 4 * μ11 * (μ30 + μ12) * (μ12 + μ03)
    R7 = (3 * μ12 - μ03) * (μ30 + μ12) * ((μ30 + μ12) ** 2 - 3 * (μ12 + μ03) ** 2) + (μ30 - 3 * μ12) * (μ12 + μ03) * (3 * (μ30 + μ12) ** 2 - (μ12 + μ03) ** 2)

    return [R1, R2, R3, R4, R5, R6, R7]

def print_matrix(matrix):
    print("Binary Matrix:")
    for row in matrix:
        print(row)

def print_moments(m10, m01, m00):
    print("\nMoments:")
    print("m10:", m10)
    print("m01:", m01)
    print("m00:", m00)

def print_rotation_invariants(rotation_invariants):
    print("\nRotation Invariants:")
    for i, ri in enumerate(rotation_invariants, start=1):
        print(f"rotation{i}: ", ri)

def compare_shapes(shape1_moments, shape2_moments):
    shape1_vector = np.array(shape1_moments)
    shape2_vector = np.array(shape2_moments)

    euclidean_distance = euclidean(shape1_vector, shape2_vector)
    manhattan_distance = cityblock(shape1_vector, shape2_vector)
    cosine_similarity = 1 - cosine(shape1_vector, shape2_vector)
    correlation_coefficient = pearsonr(shape1_vector, shape2_vector)[0]
    
    print("\nShape Comparison:")
    print("Euclidean Distance:", euclidean_distance)
    print("Manhattan Distance:", manhattan_distance)
    print("Cosine Similarity:", cosine_similarity)
    print("Correlation Coefficient:", correlation_coefficient)
    
rows = 8
cols = 8

illumination_values1 = [(3, 4), (4, 4), (5, 4), (3, 5), (4, 5), (5, 5), (6, 5), (5, 6), (6, 6)]
matrix1 = create_matrix(rows, cols, illumination_values1)
m10, m01, m00 = calculate_moments(matrix1)
moments1 = calculate_moments_dictionary(m00, m10, m01, matrix1)
rotation_invariants1 = calculate_rotation_invariants(moments1)

print("For Shape 1:")
print_matrix(matrix1)
print_moments(m10, m01, m00)
print_rotation_invariants(rotation_invariants1)

illumination_values2 = [(4, 2), (4, 3), (3, 4), (4, 4), (5, 4), (3, 5), (4, 5), (5, 5), (6, 5), (5, 6), (6, 6)]
matrix2 = create_matrix(rows, cols, illumination_values2)
m10, m01, m00 = calculate_moments(matrix2)
moments2 = calculate_moments_dictionary(m00, m10, m01, matrix2)
rotation_invariants2 = calculate_rotation_invariants(moments2)

print("\nFor Shape 2:")
print_matrix(matrix2)
print_moments(m10, m01, m00)
print_rotation_invariants(rotation_invariants2)

compare_shapes(rotation_invariants1, rotation_invariants2)